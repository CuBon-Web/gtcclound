<template>
  <div class="scp">
    <div class="scp-toolbar">
      <div>
        <label class="scp-label">Bảng giá</label>
        <span class="scp-caption">Nhiều gói — mỗi dòng: nhãn, kiểu chữ hoặc tích, giá trị.</span>
      </div>
      <vs-button type="line" size="small" color="primary" @click="addPlan">+ Thêm gói</vs-button>
    </div>

    <div v-if="!safePlans.length" class="scp-empty">
      Chưa có gói. Nhấn <strong>Thêm gói</strong> để nhập tên, giá và các dòng đặc điểm.
    </div>

    <div
      v-for="(plan, pIdx) in safePlans"
      :key="'plan-' + pIdx"
      class="scp-plan"
    >
      <div class="scp-plan-head">
        <span class="scp-badge">{{ pIdx + 1 }}</span>
        <vs-input
          class="scp-grow"
          v-model="plan.title"
          placeholder="Tên gói (VD: VoiceCloud 10 Agent)"
        />
        <vs-button type="flat" size="small" color="danger" @click="removePlan(pIdx)">Xóa</vs-button>
      </div>

      <div class="scp-plan-meta">
        <vs-input v-model="plan.price" placeholder="Giá — VD: 490.000" />
        <vs-input v-model="plan.unit" placeholder="Đơn vị — VD: tháng" />
      </div>

      <div class="scp-feats">
        <div
          v-for="(feat, fIdx) in plan.features"
          :key="'f-' + pIdx + '-' + fIdx"
          class="scp-feat"
        >
          <input
            v-model="feat.label"
            type="text"
            class="form-control form-control-sm scp-feat-label"
            placeholder="Nhãn cột trái"
          />
          <select
            v-model="feat.type"
            class="form-control form-control-sm scp-feat-type"
            @change="onFeatureTypeChange(feat)"
          >
            <option value="text">Chữ / số</option>
            <option value="boolean">Tích ✓</option>
          </select>
          <template v-if="feat.type === 'text'">
            <input
              v-model="feat.value"
              type="text"
              class="form-control form-control-sm scp-feat-val"
              placeholder="Giá trị hiển thị"
            />
          </template>
          <label v-else class="scp-feat-bool">
            <input v-model="feat.value" type="checkbox" />
            <span>Có</span>
          </label>
          <button
            type="button"
            class="scp-icon-btn"
            title="Xóa dòng"
            @click="removeFeature(pIdx, fIdx)"
          >
            ×
          </button>
        </div>
      </div>

      <div class="scp-plan-actions">
        <button type="button" class="scp-text-btn" @click="addFeature(pIdx)">+ Dòng</button>
        <button type="button" class="scp-text-btn scp-muted" @click="togglePreview(pIdx)">
          {{ previewIdx === pIdx ? "Ẩn xem trước" : "Xem trước thẻ" }}
        </button>
      </div>

      <div v-show="previewIdx === pIdx" class="scp-preview-wrap">
        <div class="scp-preview-card">
          <div class="scp-preview-head">
            <div class="scp-preview-title">{{ plan.title || "Tên gói" }}</div>
            <div class="scp-preview-price">
              <template v-if="plan.price">{{ plan.price }}đ<span v-if="plan.unit">/ {{ plan.unit }}</span></template>
              <template v-else>—</template>
            </div>
          </div>
          <div class="scp-preview-body">
            <div
              v-for="(feat, fi) in plan.features"
              :key="'pv-' + pIdx + '-' + fi"
              class="scp-preview-row"
            >
              <div class="scp-preview-cell scp-preview-label">{{ feat.label || "—" }}</div>
              <div class="scp-preview-cell scp-preview-val">
                <template v-if="feat.type === 'boolean'">
                  <i v-if="feat.value" class="mdi mdi-check scp-preview-check"></i>
                  <span v-else class="text-muted">—</span>
                </template>
                <template v-else>{{ feat.value != null && feat.value !== "" ? feat.value : "—" }}</template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { emptyFeature, emptyPlan } from "./serviceCatePricing";

export default {
  name: "ServiceCatePricingPlans",
  props: {
    plans: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  data() {
    return {
      previewIdx: null,
    };
  },
  computed: {
    safePlans() {
      return Array.isArray(this.plans) ? this.plans : [];
    },
  },
  methods: {
    currentList() {
      return Array.isArray(this.plans) ? [...this.plans] : [];
    },
    addPlan() {
      const list = this.currentList();
      list.push(emptyPlan());
      this.$emit("update:plans", list);
      this.previewIdx = list.length - 1;
    },
    removePlan(index) {
      const list = this.currentList();
      list.splice(index, 1);
      this.$emit("update:plans", list);
      if (this.previewIdx === index) {
        this.previewIdx = null;
      } else if (this.previewIdx != null && this.previewIdx > index) {
        this.previewIdx -= 1;
      }
    },
    addFeature(planIndex) {
      const plan = this.plans[planIndex];
      if (!plan) return;
      if (!Array.isArray(plan.features)) {
        this.$set(plan, "features", []);
      }
      plan.features.push(emptyFeature());
    },
    removeFeature(planIndex, featureIndex) {
      const plan = this.plans[planIndex];
      if (!plan || !Array.isArray(plan.features)) return;
      plan.features.splice(featureIndex, 1);
      if (plan.features.length === 0) {
        plan.features.push(emptyFeature());
      }
    },
    onFeatureTypeChange(feat) {
      if (feat.type === "boolean") {
        feat.value = feat.value === true || feat.value === 1 || feat.value === "1";
      } else if (typeof feat.value === "boolean") {
        feat.value = "";
      }
    },
    togglePreview(pIdx) {
      this.previewIdx = this.previewIdx === pIdx ? null : pIdx;
    },
  },
};
</script>

<style scoped>
.scp {
  border: 1px solid #e8ecf1;
  border-radius: 8px;
  padding: 12px 14px;
  background: #fafbfd;
}
.scp-toolbar {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 12px;
  margin-bottom: 10px;
}
.scp-label {
  display: block;
  font-weight: 600;
  margin-bottom: 2px;
  font-size: 0.95rem;
}
.scp-caption {
  display: block;
  font-size: 0.75rem;
  color: #6c757d;
  line-height: 1.35;
  max-width: 36rem;
}
.scp-empty {
  font-size: 0.8rem;
  color: #868e96;
  padding: 10px 0 4px;
}
.scp-plan {
  background: #fff;
  border: 1px solid #e2e6ec;
  border-radius: 8px;
  padding: 10px 12px;
  margin-bottom: 10px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
}
.scp-plan:last-child {
  margin-bottom: 0;
}
.scp-plan-head {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 8px;
}
.scp-badge {
  flex-shrink: 0;
  width: 24px;
  height: 24px;
  border-radius: 6px;
  background: #5b6ee6;
  color: #fff;
  font-size: 0.75rem;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.scp-grow {
  flex: 1;
  min-width: 0;
}
.scp-plan-meta {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  margin-bottom: 10px;
}
@media (max-width: 576px) {
  .scp-plan-meta {
    grid-template-columns: 1fr;
  }
}
.scp-feats {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.scp-feat {
  display: grid;
  grid-template-columns: minmax(0, 1.4fr) 112px minmax(0, 1fr) 32px;
  gap: 6px;
  align-items: center;
}
@media (max-width: 768px) {
  .scp-feat {
    grid-template-columns: 1fr 112px;
    grid-template-rows: auto auto;
  }
  .scp-feat-val,
  .scp-feat-bool {
    grid-column: 1 / -1;
  }
  .scp-icon-btn {
    grid-column: 2;
    grid-row: 1;
    justify-self: end;
  }
}
.scp-feat-type {
  min-height: 42px;
  padding: 10px 12px;
  line-height: 1.4;
  font-size: 0.875rem;
}
.scp-feat-bool {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  margin: 0;
  font-size: 0.8rem;
  color: #495057;
  white-space: nowrap;
}
.scp-feat-bool input {
  margin: 0;
}
.scp-icon-btn {
  border: none;
  background: transparent;
  color: #c92a2a;
  font-size: 1.25rem;
  line-height: 1;
  padding: 0 4px;
  cursor: pointer;
  border-radius: 4px;
}
.scp-icon-btn:hover {
  background: #fff5f5;
}
.scp-plan-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-top: 8px;
  padding-top: 8px;
  border-top: 1px dashed #e9ecef;
}
.scp-text-btn {
  border: none;
  background: none;
  padding: 0;
  font-size: 0.8rem;
  color: #5b6ee6;
  cursor: pointer;
  font-weight: 500;
}
.scp-text-btn:hover {
  text-decoration: underline;
}
.scp-text-btn.scp-muted {
  color: #868e96;
}
.scp-preview-wrap {
  margin-top: 10px;
}
.scp-preview-card {
  max-width: 400px;
  border-radius: 6px;
  overflow: hidden;
  border: 1px solid #dee2e6;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
}
.scp-preview-head {
  background: linear-gradient(135deg, #7b8ee8 0%, #9aa8f0 100%);
  color: #fff;
  text-align: center;
  padding: 12px 10px;
}
.scp-preview-title {
  font-weight: 700;
  font-size: 0.95rem;
  margin-bottom: 4px;
}
.scp-preview-price {
  font-weight: 700;
  font-size: 0.88rem;
}
.scp-preview-body {
  background: #f1f3f7;
  font-size: 0.78rem;
}
.scp-preview-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  border-bottom: 1px solid #dee2e6;
}
.scp-preview-row:last-child {
  border-bottom: none;
}
.scp-preview-cell {
  padding: 6px 8px;
  border-right: 1px solid #dee2e6;
}
.scp-preview-cell:last-child {
  border-right: none;
}
.scp-preview-label {
  background: #e9ecf2;
  font-weight: 500;
}
.scp-preview-val {
  text-align: center;
  background: #f8f9fb;
}
.scp-preview-check {
  color: #2e7d32;
  font-size: 1.1rem;
}
</style>
