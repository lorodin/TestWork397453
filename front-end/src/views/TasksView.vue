<template>
<div>
  <notify :message="notify" />
  <div class="title">
    <h1>
      Tasks manager
    </h1>
    <button @click="logOut">
      Logout
    </button>
  </div>
  <edit-form v-if="form.show"
             :task="form.task"
             :loading="form.loading"
             :errors="form.errors"
             @save="saveTask" @close="closeForm"/>
  <tasks-list />
</div>
</template>

<script>
import Notify from '../components/common/Notify'
import EditForm from '../components/forms/EditForm'
import TasksList from '../components/lists/TasksList'
import tasks from '../stores/tasks'

export default {
  name: 'TasksView',
  components: { Notify, EditForm, TasksList },
  data () {
    return {
      form: tasks.state.form
    }
  },
  computed: {
    notify: () => tasks.state.notify
  },
  methods: {
    saveTask (task) {
      tasks.saveTaskAction(task)
    },
    logOut () {
      tasks.resetTokenAction()
    },
    closeForm () {
      tasks.closeEditFormAction()
    }
  },
  mounted () {
    tasks.loadTasksAction()
  }
}
</script>

<style lang="scss" scoped>
.title {
  display: flex;
  justify-content: space-between;

  h1 {
    display: block;
  }

  button {
    max-height: 2em;
    margin-top: 1.6em;
  }
}
</style>
