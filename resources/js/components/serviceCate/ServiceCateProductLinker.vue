<template>
  <div class="scpl card border p-3 mb-3">
    <label class="font-weight-bold d-block mb-1">Sản phẩm hiển thị kèm trang dịch vụ</label>
    <p class="text-muted small mb-3">
      Chọn <strong>danh mục sản phẩm (cấp 1)</strong>, sau đó với mỗi <strong>nhóm cấp 2</strong> chọn áp dụng toàn bộ hoặc chọn riêng các nhóm <strong>cấp 3</strong>.
    </p>

    <div class="form-group mb-3">
      <label class="small text-muted">Danh mục sản phẩm (cấp 1)</label>
      <vs-select
        class="w-100"
        label-placeholder="Chọn danh mục…"
        v-model="categoryId"
        @input="onCategoryChanged"
      >
        <vs-select-item
          v-for="c in categories"
          :key="'cat-' + c.id"
          :value="c.id"
          :text="decodeName(c.name)"
        />
      </vs-select>
    </div>

    <div v-if="loadingTypes" class="text-muted small py-2">Đang tải danh mục cấp 2…</div>

    <div v-else-if="categoryId && typeRows.length === 0" class="text-muted small">
      Không có danh mục cấp 2 trong nhóm này.
    </div>

    <div v-else-if="typeRows.length" class="table-responsive">
      <table class="table table-sm table-bordered mb-0 scpl-table">
        <thead class="thead-light">
          <tr>
            <th>Danh mục cấp 2</th>
            <th style="width: 220px">Áp dụng</th>
            <th>Danh mục cấp 3 (khi chọn “Chọn nhóm cấp 3”)</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in typeRows" :key="'tp-' + row.id">
            <td>{{ row.label }}</td>
            <td>
              <select class="form-control form-control-sm scp-feat-type" v-model="row.mode" @change="onModeChange(row)">
                <option value="off">Không hiển thị</option>
                <option value="all">Toàn bộ SP trong nhóm</option>
                <option value="some">Chọn nhóm cấp 3</option>
              </select>
            </td>
            <td>
              <div v-if="row.mode !== 'some'" class="text-muted small">—</div>
              <div v-else-if="row.loadingTwos" class="small text-muted">Đang tải…</div>
              <div v-else class="scpl-twos">
                <label v-for="t2 in row.twoOptions" :key="'t2-' + row.id + '-' + t2.id" class="scpl-twos__item">
                  <input type="checkbox" :value="t2.id" v-model="row.twoSelected" @change="emitSelections" />
                  <span>{{ decodeName(t2.name) }}</span>
                </label>
                <div v-if="row.twoOptions.length === 0" class="text-muted small">Không có danh mục cấp 3.</div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import { normalizeLinkedProductCategories } from "./serviceCateLinkedProducts";

export default {
  name: "ServiceCateProductLinker",
  props: {
    value: {
      type: Object,
      default() {
        return { selections: [] };
      },
    },
  },
  data() {
    return {
      categories: [],
      categoryId: null,
      typeRows: [],
      loadingTypes: false,
      hydrating: false,
    };
  },
  watch: {
    value: {
      deep: true,
      handler() {
        if (!this.hydrating) {
          this.hydrateFromValue();
        }
      },
    },
  },
  mounted() {
    this.loadings(true);
    this.listCate({ keyword: "" })
      .then((res) => {
        this.categories = res.data || [];
        this.loadings(false);
        this.hydrateFromValue();
      })
      .catch(() => {
        this.loadings(false);
      });
  },
  methods: {
    ...mapActions(["listCate", "findTypeCate", "findTypeCateTwo", "loadings"]),
    decodeName(raw) {
      if (raw == null || raw === "") return "";
      if (typeof raw === "object") {
        const arr = Array.isArray(raw) ? raw : [raw];
        if (arr[0] && arr[0].content) return arr[0].content;
      }
      if (typeof raw === "string") {
        try {
          const j = JSON.parse(raw);
          if (Array.isArray(j) && j[0] && j[0].content) return j[0].content;
        } catch (e) {
          return raw;
        }
      }
      return String(raw);
    },
    hydrateFromValue() {
      const norm = normalizeLinkedProductCategories(this.value);
      const sels = norm.selections || [];
      const catIds = [...new Set(sels.map((s) => s.category_id).filter(Boolean))];
      this.categoryId = catIds.length >= 1 ? catIds[0] : null;
      if (!this.categoryId) {
        this.typeRows = [];
        return;
      }
      this.fetchTypesAndApplySelections(sels);
    },
    onCategoryChanged() {
      this.fetchTypesAndApplySelections([]);
    },
    fetchTypesAndApplySelections(appliedSelections) {
      const skipEmit = Array.isArray(appliedSelections) && appliedSelections.length > 0;
      if (!this.categoryId) {
        this.typeRows = [];
        if (!skipEmit) this.emitSelections();
        return;
      }
      this.loadingTypes = true;
      this.findTypeCate(this.categoryId)
        .then((res) => {
          const types = res.data || [];
          const byType = {};
          const src =
            Array.isArray(appliedSelections) && appliedSelections.length
              ? appliedSelections
              : normalizeLinkedProductCategories(this.value).selections;
          src.forEach((s) => {
            byType[s.type_cate_id] = s;
          });
          this.typeRows = types.map((tp) => {
            const hit = byType[tp.id];
            let mode = "off";
            let twoSelected = [];
            if (hit) {
              mode = hit.type_two_ids && hit.type_two_ids.length ? "some" : "all";
              twoSelected = (hit.type_two_ids || []).slice();
            }
            return {
              id: tp.id,
              label: this.decodeName(tp.name),
              mode,
              twoSelected,
              twoOptions: [],
              loadingTwos: false,
            };
          });
          this.loadingTypes = false;
          this.typeRows.forEach((row) => {
            if (row.mode === "some") {
              this.loadTwosForRow(row, true);
            }
          });
          if (!skipEmit) {
            this.emitSelections();
          }
        })
        .catch(() => {
          this.loadingTypes = false;
        });
    },
    loadTwosForRow(row, silentEmit) {
      row.loadingTwos = true;
      this.findTypeCateTwo(row.id)
        .then((res) => {
          row.twoOptions = res.data || [];
          row.loadingTwos = false;
          row.twoSelected = row.twoSelected.filter((id) => row.twoOptions.some((t) => t.id === id));
          if (!silentEmit) this.emitSelections();
        })
        .catch(() => {
          row.loadingTwos = false;
        });
    },
    onModeChange(row) {
      if (row.mode === "some") {
        this.loadTwosForRow(row, false);
      } else {
        row.twoSelected = [];
        row.twoOptions = [];
        this.emitSelections();
      }
    },
    emitSelections() {
      const selections = [];
      if (!this.categoryId) {
        this.$emit("input", { selections: [] });
        return;
      }
      this.typeRows.forEach((row) => {
        if (row.mode === "off") return;
        if (row.mode === "some" && (!row.twoSelected || !row.twoSelected.length)) return;
        selections.push({
          category_id: Number(this.categoryId),
          type_cate_id: row.id,
          type_two_ids: row.mode === "all" ? [] : (row.twoSelected || []).map(Number),
        });
      });
      this.hydrating = true;
      this.$emit("input", { selections });
      this.$nextTick(() => {
        this.hydrating = false;
      });
    },
  },
};
</script>

<style scoped>
.scpl-table th,
.scpl-table td {
  vertical-align: middle;
}
.scpl-twos {
  display: flex;
  flex-direction: column;
  gap: 4px;
  max-height: 180px;
  overflow-y: auto;
}
.scpl-twos__item {
  display: flex;
  align-items: flex-start;
  gap: 6px;
  margin: 0;
  font-size: 0.85rem;
}
.scpl-twos__item input {
  margin-top: 3px;
}
.scp-feat-type {
  padding: 5px 18px 5px 18px;
}
</style>
