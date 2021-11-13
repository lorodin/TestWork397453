import axios from 'axios'

const API_URL_TASKS = `${process.env.VUE_APP_API_HOST}tasks/`
const API_URL_LOGIN = `${process.env.VUE_APP_API_HOST}login`
const API_URL_REGISTER = `${process.env.VUE_APP_API_HOST}register`

const LIST = 'list'
const ADD = 'create'
const UPDATE = 'update'
const DELETE = 'delete'

const SUCCESS = 'success'
const STATUS_UNAUTHOTIZED = 401
const STATUS_INVALIDATE = 422

const selfFun = (f) => f || (() => {})

function getHeaders () {
  return {
    Authorization: 'Bearer ' + localStorage.getItem('token')
  }
}

function get (url, onSuccess, onUnAuth, onError) {
  axios.get(url, {
    headers: getHeaders()
  }).then(resp => onSuccess(resp.data.data))
    .catch(err => {
      const { response } = err
      if (response.status === STATUS_UNAUTHOTIZED) {
        onUnAuth()
      } else {
        if (process.env.VUE_APP_DEBUG) {
          console.error(err)
        }
        onError(err)
      }
    })
}

function post (url, data, onSuccess, onError, onInvalid, onUnAuth = () => {}) {
  axios.post(url, data, { headers: getHeaders() })
    .then(resp => {
      const { data } = resp
      if (data.status === SUCCESS) {
        onSuccess(data.data)
      } else {
        if (process.env.VUE_APP_DEBUG) {
          console.error(resp)
        }
        onError(resp)
      }
    })
    .catch(err => {
      const response = { err }
      if (response.status === STATUS_INVALIDATE) {
        onInvalid(response.data.errors)
      } else if (response.status === STATUS_UNAUTHOTIZED) {
        onUnAuth()
      } else {
        if (process.env.VUE_APP_DEBUG) {
          console.error(err)
        }
        onError(err)
      }
    })
}

function del (url, onSuccess, onError, onUnAuth) {
  axios.delete(url, { headers: getHeaders() })
    .then(onSuccess)
    .catch(err => {
      const { response } = err

      if (response.status === STATUS_UNAUTHOTIZED) {
        onUnAuth()
      } else {
        if (process.env.VUE_APP_DEBUG) {
          console.error(err)
        }
        onError(err)
      }
    })
}

function register ({
  data,
  onSuccess,
  onError,
  onInvalid
}) {
  post(
    API_URL_REGISTER,
    data,
    selfFun(onSuccess),
    selfFun(onError),
    selfFun(onInvalid)
  )
}

function login ({
  data,
  onSuccess,
  onError,
  onInvalid
}) {
  post(
    API_URL_LOGIN,
    data,
    selfFun(onSuccess),
    selfFun(onError),
    selfFun(onInvalid)
  )
}

function addTask ({
  task,
  onSuccess,
  onError,
  onInvalid,
  onUnAuth
}) {
  post(
    `${API_URL_TASKS}${ADD}`,
    task,
    selfFun(onSuccess),
    selfFun(onError),
    selfFun(onInvalid),
    selfFun(onUnAuth)
  )
}

function updateTask ({
  task,
  onSuccess,
  onError,
  onInvalid,
  onUnAuth
}) {
  if (!task.id || isNaN(task.id)) {
    if (process.env.VUE_APP_DEBUG) {
      console.error('Task id not set ot it`s not a number ' + task.id)
    }
    return
  }

  post(
    `${API_URL_TASKS}${UPDATE}/${task.id}`,
    task,
    selfFun(onSuccess),
    selfFun(onError),
    selfFun(onInvalid),
    selfFun(onUnAuth)
  )
}

function getList ({
  page,
  onSuccess,
  onError,
  onUnAuth
}) {
  get(`${API_URL_TASKS}${LIST}/${page || ''}`,
    selfFun(onSuccess),
    selfFun(onUnAuth),
    selfFun(onError)
  )
}

function delTask ({
  id,
  onSuccess,
  onError,
  onUnAuth
}) {
  if (!id || isNaN(id)) {
    if (process.env.VUE_APP_DEBUG) {
      console.error('Task id not set ot it`s not a number ' + id)
    }
    return
  }

  del(
    `${API_URL_TASKS}${DELETE}/${id}`,
    selfFun(onSuccess),
    selfFun(onError),
    selfFun(onUnAuth)
  )
}

export default {
  addTask,
  getList,
  delTask,
  updateTask,
  register,
  login
}
