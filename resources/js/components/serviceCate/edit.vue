<template>
  <div>
      <div class="row">
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-3"><h4 class="card-title">Sửa danh mục sản phẩm</h4></div>
                <div class="col-md-6"></div>
                <div class="col-md-3">
                  </div>
              </div>

              <form class="forms-sample">
                <div class="form-group">
                <label>Tên</label>
                  <vs-input
                    class="w-100"
                    v-model="objData.name"
                    font-size="40px"
                  />
                </div>
                <div class="form-group">
                  <label>Ảnh đại diện</label>
                  <image-upload
                    v-model="objData.image"
                    type="avatar"
                    :title="'danh-muc-dich-vu'"
                  ></image-upload>
                </div>
                <div class="form-group">
                <label>Mô tả ngắn</label>
                 <textarea class="form-control" rows="3" v-model="objData.description" ></textarea>
                </div>
                <div class="form-group">
                <label>Nội dung</label>
                 <TinyMce v-model="objData.content" />
                </div>

                <div class="form-group">
                  <service-cate-pricing-plans :plans.sync="objData.pricing_plans" />
                </div>

                <div class="form-group">
                  <service-cate-product-linker v-model="objData.linked_product_categories" />
                </div>

                <div class="form-group">
                  <label for="exampleInputName1">Trạng thái</label>
                  <vs-select v-model="objData.status"
                  >
                      <vs-select-item  value="1" text="Hiện" />
                      <vs-select-item  value="0" text="Ẩn" />
                    </vs-select>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row fixxed">
        <div class="col-12">
          <div class="saveButton">
            <vs-button color="primary" @click="saveEdit()">Cập nhật</vs-button>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import TinyMce from "../_common/tinymce";
import ServiceCatePricingPlans from "./ServiceCatePricingPlans.vue";
import ServiceCateProductLinker from "./ServiceCateProductLinker.vue";
import { serializePricingPlans, normalizePricingPlans } from "./serviceCatePricing";
import { serializeLinkedProductCategories, normalizeLinkedProductCategories } from "./serviceCateLinkedProducts";

export default {
  data() {
    return {
      showLang:{
        title:false
      },
      objData: {
        id:this.$route.params.id,
        name: "",
        content: "",
        image: "",
        status: "",
        description:"",
        pricing_plans: [],
        linked_product_categories: { selections: [] },
      },
      lang:[],
      img: "",
      errors:[]
    };
  },
  components: {
    TinyMce,
    ServiceCatePricingPlans,
    ServiceCateProductLinker,
  },
  methods: {
    ...mapActions(["getInfoCateService","saveCategoryService","listLanguage", "loadings"]),
    normalizeLoadedPricing(data) {
      if (!data || typeof data !== "object") return;
      this.$set(data, "pricing_plans", normalizePricingPlans(data.pricing_plans));
      this.$set(data, "linked_product_categories", normalizeLinkedProductCategories(data.linked_product_categories));
    },
    nameImage(event) {
      this.objData.avatar = event;
    },
    showSettingLangExist(value){
        this.showLang.title = !this.showLang.title
          this.lang.forEach((value, index) => {
              if(!this.objData.name[index] && value.code != this.objData.name[0].lang_code){
                  var oj = {};
                  oj.lang_code = value.code;
                  oj.content = ''
                  this.objData.name.push(oj)
              }
          });
    },
    saveEdit() {
      this.errors = [];
      if(this.objData.name == '') this.errors.push('Tên danh mục không được để trống');
      if(this.objData.description == '') this.errors.push('Mô tả ngắn không để trống');
      if (this.errors.length > 0) {
        this.errors.forEach((value, key) => {
          this.$error(value)
        })
        return;
      } else {
        const payload = { ...this.objData };
        payload.pricing_plans = serializePricingPlans(payload.pricing_plans);
        payload.linked_product_categories = serializeLinkedProductCategories(payload.linked_product_categories);

        this.loadings(true);
        this.saveCategoryService(payload)
        .then(response => {
            this.loadings(false);
            this.$router.push({ name: "list_category_service" });
            this.$success("Sửa danh mục thành công");
          })
        .catch(error => {
            this.loadings(false);
          });
      }
    },
    listLang(){
      this.listLanguage().then(response => {
        this.loadings(false);
        this.lang  = response.data
      }).catch(error => {

      })
    },
    getInfoCates(){
      this.loadings(true);
      this.getInfoCateService(this.objData).then(response => {
        this.loadings(false);
        if(response.data == null){
          this.objData ={
            id:this.$route.params.id,
            name: "",
            content: "",
            image: "",
            status: "",
            description: "",
            pricing_plans: [],
            linked_product_categories: { selections: [] },
          }
        }else{
          this.objData = response.data;
          this.normalizeLoadedPricing(this.objData);
        }
      }).catch(error => {
        console.log(12);
      });
    },
    changeLanguage(data){
      this.getInfoCates();
    }
  },
  mounted() {
    this.loadings(true);
    this.getInfoCates();
    this.listLang();
  }
};
</script>

<style>
</style>
