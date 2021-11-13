import axios from 'axios'

const API_URL_TASKS = `${process.env.VUE_APP_API_HOST}tasks/`
const API_URL_LOGIN = `${process.env.VUE_APP_API_HOST}login`
const API_URL_REGISTER = `${process.env.VUE_APP_API_HOST}register`

const LIST = 'list'
const ADD = 'create'
const UPDATE = 'update'
const DELETE = 'delete'

const SUCCESS = 'success'

function getHeaders () {
  return {
    Authorization: 'Bearer ' + localStorage.getItem('token')
  }
}

async function get (url) {
  return axios.get(url, {
    headers: getHeaders()
  })
}

async function post (url, data) {
  return axios.post(url, data, {
    headers: getHeaders()
  })
}

async function del (url) {
  return axios.delete(url, {
    headers: getHeaders()
  })
}

function register ({
  data,
  onSuccess,
  onError,
  onInvalid
}) {
  post(API_URL_REGISTER, data)
    .then(resp => {
      const { data } = resp
      if (data.status === SUCCESS) {
        onSuccess(data.data.token)
      } else {
        console.error(resp)
        onError(resp)
      }
    })
    .catch(err => {
      const { response } = err
      if (response.status === 422) {
        onInvalid(response.data.errors)
      } else {
        console.error(err)
        onError(err)
      }
    })
}

function login ({
  data,
  onSuccess,
  onError,
  onInvalid
}) {
  post(API_URL_LOGIN, data)
    .then(resp => {
      const { data } = resp
      if (data.status === SUCCESS) {
        onSuccess(data.data.token)
      } else {
        onError(data)
      }
    })
    .catch(err => {
      const { response } = err
      if (response.status === 422) {
        onInvalid(response.data.errors)
      } else {
        console.error(err)
        onError(err)
      }
    })
}

function addTask ({
  task,
  onSuccess,
  onError,
  onInvalid,
  onUnAuth
}) {
  post(`${API_URL_TASKS}${ADD}`, task)
    .then((response) => {
      const { data } = response

      if (data.status === SUCCESS) {
        onSuccess(data.data)
      } else if (onError) {
        onError(data)
      }
    })
    .catch((err) => {
      const { response } = err

      if (response.status === 422) {
        onInvalid(response.data.errors)
      } else if (response.status === 401) {
        onUnAuth()
      } else {
        onError(err)
      }
    })
}

function updateTask ({
  task,
  onSuccess,
  onError,
  onInvalid,
  onUnAuth
}) {
  if (!task.id || isNaN(task.id)) {
    throw new Error('Task id not set ot it`s not a number ' + task.id)
  }

  post(`${API_URL_TASKS}${UPDATE}/${task.id}`, task)
    .then(response => {
      const { data } = response

      if (data.status === SUCCESS) {
        onSuccess(data)
      } else {
        onError(response)
      }
    })
    .catch(err => {
      const { response } = err
      if (response.status === 422) {
        onInvalid(response.data.errors)
      } else if (response.status === 401) {
        onUnAuth()
      } else {
        onError(err)
      }
    })
}

function getList ({
  page,
  onSuccess,
  onError,
  onUnAuth
}) {
  get(`${API_URL_TASKS}${LIST}/${page || ''}`)
    .then(response => {
      const { data } = response

      if (data.status === SUCCESS) {
        onSuccess(data.data)
      } else {
        onError(data)
      }
    })
    .catch(err => {
      const { response } = err
      if (response.status === 401) {
        onUnAuth()
      } else {
        onError(err)
      }
    })
}

function delTask ({
  id,
  onSuccess,
  onError,
  onUnAuth
}) {
  if (!id || isNaN(id)) {
    throw new Error('Id not setting or it`s not a number')
  }

  del(`${API_URL_TASKS}${DELETE}/${id}`)
    .then(response => {
      const { data } = response

      if (data.status === SUCCESS) {
        onSuccess()
      } else {
        onError(data)
      }
    })
    .catch(err => {
      const { response } = err

      if (response.data.status === 401) {
        onUnAuth()
      } else {
        onError(err)
      }
    })
}

export default {
  addTask,
  getList,
  delTask,
  updateTask,
  register,
  login
}
