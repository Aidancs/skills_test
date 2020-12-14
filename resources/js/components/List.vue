<template>
  <div class="list-group-item">
    <form>
      <div>Task Name: {{ task.task_name }}</div>
      <div>Priority: {{ task.priority }}</div>
      <div v-if="edit">
        <input class="input" v-model="new_task_name" value="new_task_name" />
        <button
          type="button"
          v-on:click="edit = !edit"
          class="btn btn-secondary"
          @click="edit_task(task.id, new_task_name)"
        >
          Edit Task Name
        </button>
      </div>
      <div v-if="!edit">
        <button v-on:click="edit = !edit" class="btn btn-secondary">
          Edit Task Name
        </button>
      </div>
      <button
        class="btn btn-secondary"
        @click="delete_task(task.id, task.priority)"
      >
        Delete Task
      </button>
    </form>
  </div>
</template>
<script>
export default {
  props: {
    task: Object,
  },
  data() {
    return {
      task_name: "",
      new_task_name: "",
      edit: false,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },
  methods: {
    edit_task: function (task_id, name) {
      axios
        .get("api/tasks/" + task_id + "/" + name)
        .then((response) => {
          // alert for successful edit
        })
        .catch((error) => {
          // alert for unsuccessful deletion
        });
    },
    delete_task: function (task_id, task_priority) {
      axios
        .delete("api/tasks/" + task_id + "/delete", {
          priority: task_priority,
        })
        .then((response) => {
          // alert for successful deletion
        })
        .catch((error) => {
          // alert for unsuccessful deletion
        });
    },
  },
};
</script>
<style>
.input {
  border: 2px solid black;
}

.list-group-item {
  border: 2px solid black;
  margin-left: -25px;
  padding: 20px 20px 20px 20px;
}
</style>
