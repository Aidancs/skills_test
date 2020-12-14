<template>
  <div class="container">
    <div>
      <h3 class="title">Draggable Tasks {{ draggingInfo }}</h3>
      <draggable
        :list="tasks"
        :disabled="!enabled"
        class="list-group"
        ghost-class="ghost"
        @start="dragging = true"
        @end="draggingEnd()"
      >
        <task-list
          v-for="task in tasks"
          :key="task.id"
          :task="task"
        ></task-list>
      </draggable>
      <form>
        Task Name:
        <input class="input" v-model="task_name" value="task_name" />
        <button
          class="btn btn-secondary create"
          @click="create_task(task_name)"
        >
          Create Task
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import draggable from "vuedraggable";
let id = 1;
export default {
  order: 0,
  components: {
    draggable,
  },
  data() {
    return {
      enabled: true,
      dragging: false,
      tasks: [],
      task_name: "",
      new_task_name: "",
      edit: false,
    };
  },
  computed: {
    draggingInfo() {
      return this.dragging ? "dragging" : "";
    },
  },
  methods: {
    create_task: function (task_name) {
      axios
        .post("api/tasks/create", {
          task_name: task_name,
        })
        .then((response) => {
          // alert for task creation
        })
        .catch((error) => {
          // alert for failure to create
        });
    },

    draggingEnd: function (e) {
      this.dragging = false;
      this.updateTaskPriority();
    },
    loadTasks: function () {
      axios
        .get("/api/tasks")
        .then((response) => {
          console.log(response);
          this.tasks = response.data;
        })
        .catch((error) => {
          console.log(error);
          // alert for failure to load
        });
    },
    updateTaskPriority: function () {
      this.tasks.map((task, index) => {
        task.priority = index + 1;
      });

      axios
        .post("api/tasks/update", {
          tasks: this.tasks,
        })
        .then((response) => {
          // alert for successful update of task
        })
        .catch((error) => {
          // alert for failure to update
        });
    },
  },
  mounted() {
    this.loadTasks();
  },
};
</script>
<style>
.buttons {
  margin-top: 35px;
}

.btn-danger {
  background-color: red;
}

.container {
  display: flex;
  justify-content: center;
}

.center {
  width: 800px;
}

.create {
  margin-top: 20px;
  margin-left: 25px;
}

.ghost {
  opacity: 0.5;
  background: #c8ebfb;
}

.input {
  border: 2px solid black;
}

.list-group-item {
  border: 2px solid black;
  margin-left: -25px;
  padding: 20px 20px 20px 20px;
}

.title {
  margin-left: 100px;
}
</style>
