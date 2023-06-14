<template>
  <div class="mt-2">
    <el-dialog
        ref="roadmapForm"
        :close-on-click-modal="false"
        v-model="modalVisiable"
        @close="closeRoadMaplModal"
        title="Create roadmap"
    >
      <el-form
          label-width="100px"
          @submit.prevent="handleSubmit"
      >
        <el-row>
          <el-col>
            <el-form-item required>
              <el-input class="form-description" v-model="form.description"
                        type="textarea"
                        required
                        placeholder="What would you like to be able to do? How would that help you?"
              />
            </el-form-item>
            <span class="field-required">{{descriptionMessage}}</span>
          </el-col>
        </el-row>

        <el-row>
          <p>How important is this to you?</p>
          <el-col>
            <el-form-item>
              <el-radio-group v-model="form.status">
                <el-radio label="1" size="large" border>Not Important</el-radio>
                <el-radio label="2" size="large" border>Nice to Have</el-radio>
                <el-radio label="3" size="large" border>Important</el-radio>
                <el-radio label="4" size="large" border>Danger</el-radio>
              </el-radio-group>
            </el-form-item>

            <span class="field-required">{{statusMessage}}</span>
          </el-col>
        </el-row>

        <el-form-item label="Email">
          <el-input
              v-model="form.email"
              type="email"
              autocomplete="off"
          />

          <span class="field-required">{{emailMessage}}</span>
        </el-form-item>

        <div class="dialog-footer-btns">
        <span class="dialog-footer">
          <el-button @click="closeRoadMaplModal">Cancel</el-button>
          <el-button type="primary" native-type="submit">
            Save
          </el-button>
        </span>
        </div>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>
import { ElNotification } from 'element-plus'
export default {
  props: ['modalShow'],
  data() {
    return {
      isModalShow: true,
      formData: [],
      modalVisiable: false,
      emailMessage: '',
      statusMessage: '',
      descriptionMessage: '',
      form: {
        description: '',
        status: '',
        email: '',
      },
    }
  },
  watch: {
    modalShow(newValue, oldValue) {
      if(newValue) {
        this.modalVisiable = newValue
      }
    },
    'form.description'(newValue, oldValue) {
      if(newValue) {
        if(this.form.description !== ''){
          this.descriptionMessage = ""
        }
      }
    },
    'form.email'(newValue, oldValue) {
      if(newValue) {
        if(this.form.email !== ''){
          this.emailMessage = ""
        }
      }
    },
    'form.status'(newValue, oldValue) {
      if(newValue) {
        if(this.form.status !== ''){
          this.statusMessage = ""
        }
      }
    }
  },
  methods: {
    validateEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (emailRegex.test(email)) {
        return true;
      } else {
        return false;
      }
    },

    closeRoadMaplModal(){
      this.modalVisiable = false
      this.resetModal()
      this.$emit('modalFormStatus', this.modalVisiable);
    },
    handleSubmit() {
      console.log('improve')
      const isValidated = this.validateEmail(this.form.email)
      if(this.form.description === ''){
        return this.descriptionMessage = "The description field is required!"
      }else if(this.form.status === ''){
        return this.statusMessage = "The status field is required!"
      }else if(this.form.email === '' || !isValidated){
        return this.emailMessage = "The email field is required!"
      }
      const dataToSubmit = {
        action: 'create_crm_roadmap',
        ...this.form
      }

      const ajaxUrl = window.wp_roadmap_ajax.ajax_url;

      window.jQuery.ajax({
        url: ajaxUrl,
        data: dataToSubmit,
        method: 'POST'
      }).done((response) => {
        if (response) {
          ElNotification({
            title: 'Success',
            message: 'Successfully added',
            type: 'success',
          })
          this.resetModal();
          this.modalVisiable = false
          this.$emit('getNewData');
        }
      });
    },
    resetModal () {
      this.form.description = null
      this.form.status = null
      this.form.email= null
    }
  }
}
</script>

<style scoped>
.el-form-item__content{
  margin-left: 0px !important;
}
.field-required{
  color: red;
}
</style>