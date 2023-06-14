<template>
  <div class="mt-3">
    <h2>Roadmaps</h2>
    <el-row class="mt-4 mb-2">
      <el-button
          @click="showRoadmapModal = true"
          :icon="Plus"
          type="primary">
        Add New
      </el-button>

    </el-row>

    <el-table :data="roadmaps" border style="width: 100%;margin-top: 5px">
      <el-table-column prop="description" label="Description" width="180" />
      <el-table-column label="Status" width="180">
        <template #default="scope">
          <el-tag v-if="scope.row.status == 1">Not Important</el-tag>
          <el-tag v-else-if="scope.row.status == 2" type="info">Nice to Have</el-tag>
          <el-tag v-else-if="scope.row.status == 3" type="success">Important</el-tag>
          <el-tag v-else-if="scope.row.status == 4" type="warning">Danger</el-tag>
        </template>
      </el-table-column>
      <el-table-column prop="email" label="Email" />
    </el-table>

    <RoadmapForm
        :modalShow="showRoadmapModal"
        @modalFormStatus="handleModalStatusUpdate"
        @getNewData="getItems"
    />
  </div>
</template>
<script>
import RoadmapForm from './components/Roadmap/RoadmapFormModal.vue';
import {Plus} from "@element-plus/icons";
export default {
  name: 'Dashboard',
  components: {RoadmapForm},
  computed: {
    Plus() {
      return Plus
    }
  },
  data() {
    return {
      roadmaps : [],
      singleRoadmaps: {},
      isEditable: false,
      showRoadmapModal: false,
    }
  },

  methods: {
    handleModalStatusUpdate(status) {
      this.showRoadmapModal = status
      this.isEditable = false
    },
    handleUpdateHandler() {
      this.isEditable = true;
      this.showRoadmapModal = true;
    },
    handleDelete(roadmapId) {
      const dataToSubmit = {
        action: 'delete_roadmap',
        id: roadmapId,
      }
      const roadmapUrl = window.wp_roadmap_ajax.ajax_url;

      window.jQuery.ajax({
        url: roadmapUrl,
        data: dataToSubmit,
        method: 'POST'
      }).done((response) => {
        this.getItems()
      });
    },
    getItems() {
      const dataToSubmit = {
        action: 'get_roadmaps',
      }
      const roadmapUrl = window.wp_roadmap_ajax.ajax_url;

      window.jQuery.ajax({
        url: roadmapUrl,
        data: dataToSubmit,
        method: 'POST'
      }).done((response) => {
        this.roadmaps = response
      });
    }
    },
    mounted() {
      this.getItems();
    }
  }
</script>