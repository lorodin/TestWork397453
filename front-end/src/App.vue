<template>
  <div class="page">
    <notify :message="notify" />
    <h1 class="title">
      Tasks manager
    </h1>
    <edit-form v-if="form.show"
               :task="form.task"
               :loading="form.loading"
               :errors="form.errors"
               @save="saveTask" @close="closeForm"/>
    <tasks-list />
  </div>
</template>

<script>
import TasksList from './components/lists/TasksList'
import tasks from './stores/tasks'
import EditForm from './components/forms/EditForm'
import Notify from './components/common/Notify'

export default {
  name: 'App',
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
    saveTask: (task) => {
      tasks.saveTaskAction(task)
    },
    closeForm: () => {
      tasks.closeEditFormAction()
    }
  },
  mounted () {
    tasks.loadTasksAction()
  }
}
</script>

<style lang='scss'>
  .page {
    width: 1024px;
    @media screen and (max-width: 1024px){
      width: 100%;
    }
  }
</style>
