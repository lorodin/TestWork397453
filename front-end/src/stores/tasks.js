import { reactive } from 'vue'
import api from '../core/api'

export default {
  state: reactive({
    pageInfo: {
      loading: false,
      current: 1,
      pages: 1
    },
    tasks: [],
    notify: '',
    form: {
      show: false,
      loading: false,
      errors: [],
      task: {
        id: 0,
        name: '',
        description: ''
      }
    }
  }),

  closeEditFormAction () {
    this.state.form.show = false
  },

  openEditFormAction (id = 0) {
    this.state.form.task = [{
      id: 0,
      name: '',
      description: '',
      completed: false
    }].concat(this.state.tasks).find(t => t.id === id)

    this.state.form.errors = []
    this.state.form.show = true
  },

  toggleCompleteAction (id) {
    const task = this.state.tasks.find(t => t.id === id)
    if (!task) {
      console.error(`Task with id ${id} not found`)
      return
    }

    task.completed = !task.completed
    api.updateTask({
      task,
      onSuccess: () => {
        this.loadTasksAction(this.state.pageInfo.current)
      },
      onError: (resp) => {
        console.error(resp)
      }
    })
  },

  saveTaskAction (task) {
    this.state.form.loading = true
    this.state.form.error = false

    const endpoint = task.id ? api.updateTask : api.addTask

    endpoint({
      task: task,
      onSuccess: () => {
        this.state.form.loading = false
        this.state.form.show = false
        this.state.notify = `Task ${task.id ? 'updated' : 'saved'} successfully`

        setTimeout(() => {
          this.state.notify = ''
        }, 3000)

        this.loadTasksAction()
      },
      onError: (resp) => {
        console.error(resp)
        this.state.form.loading = false
      },
      onInvalid: (errors) => {
        this.state.form.errors = Object.entries(errors).map(err => err[0])
        this.state.form.loading = false
      }
    })
  },

  loadTasksAction ({ page } = { page: 0 }) {
    this.state.pageInfo.loading = true

    api.getList({
      page: page,
      onSuccess: (data) => {
        this.state.pageInfo.pages = (data.count + data.per_page - data.count % data.per_page) / data.per_page
        this.state.pageInfo.current = data.page
        this.state.tasks = data.list
        this.state.pageInfo.loading = false
      },
      onError: (err) => {
        this.state.pageInfo.loading = false
        console.error(err)
      }
    })
  },

  deleteTaskAction (id) {
    this.state.pageInfo.loading = true

    api.delTask({
      id: id,
      onSuccess: () => {
        this.loadTasksAction()
      },
      onError: (resp) => {
        console.log(resp)
        this.state.pageInfo.loading = false
      }
    })
  }
}
