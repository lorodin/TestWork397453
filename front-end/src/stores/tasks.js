import { reactive } from 'vue'
import api from '../core/api'

export default {
  state: reactive({
    login: {
      loading: false,
      errors: {}
    },
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

  resetTokenAction () {
    console.log('reset token')
    localStorage.setItem('token', '')
    window.location = '/login'
  },

  loginAction (data) {
    this.state.login.loading = true

    api.login({
      data,
      onSuccess: (token) => {
        localStorage.setItem('token', token)
        console.log(token)
        window.location = '/'
      },
      onInvalid: (errors) => {
        console.log(errors)
        this.state.login.errors = errors
        this.state.login.loading = false
      },
      onError: (err) => {
        this.state.login.loading = false
        if (err.message) {
          this.state.login.errors.login = [err.message]
        }
      }
    })
  },

  registerAction (data) {
    this.state.login.loading = true

    api.register({
      data,
      onSuccess: (token) => {
        localStorage.setItem('token', token)
        console.log(token)
        window.location = '/'
      },
      onInvalid: (errors) => {
        console.log(errors)
        this.state.login.errors = errors
        this.state.login.loading = false
      }
    })
  },

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
      },
      onUnAuth: () => {
        this.resetTokenAction()
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
        this.state.form.errors = errors
        this.state.form.loading = false
      },
      onUnAuth: () => {
        this.resetTokenAction()
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
      },
      onUnAuth: () => {
        console.log('Auth error')
        this.resetTokenAction()
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
      },
      onUnAuth: () => {
        this.resetTokenAction()
      }
    })
  }
}
