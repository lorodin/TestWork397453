import axios from 'axios'

const HOST = `${process.env.VUE_APP_API_HOST}tasks/`
const LIST = 'list'
const ADD = 'create'
const UPDATE = 'update'
const DELETE = 'delete'

const SUCCESS = 'success'

async function get (url) {
  return axios.get(url)
}

async function post (url, data) {
  return axios.post(url, data)
}

async function del (url) {
  return axios.delete(url)
}

function addTask ({
  task,
  onSuccess,
  onError,
  onInvalid
}) {
  post(`${HOST}${ADD}`, task)
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

      if (response.data.status === 422) {
        onInvalid(response.data.errors)
      } else {
        onError(err)
      }
    })
}

function updateTask ({
  task,
  onSuccess,
  onError,
  onInvalid
}) {
  if (!task.id || isNaN(task.id)) {
    throw new Error('Task id not set ot it`s not a number ' + task.id)
  }

  post(`${HOST}${UPDATE}/${task.id}`, task)
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
      console.log(response)
      if (response.status === 422) {
        onInvalid(response.data.errors)
      } else {
        onError(err)
      }
    })
}

function getList ({
  page,
  onSuccess,
  onError
}) {
  get(`${HOST}${LIST}/${page || ''}`)
    .then(response => {
      const { data } = response

      if (data.status === SUCCESS) {
        onSuccess(data.data)
      } else {
        onError(data)
      }
    })
    .catch(err => {
      onError(err)
    })
}

function delTask ({
  id,
  onSuccess,
  onError
}) {
  if (!id || isNaN(id)) {
    throw new Error('Id not setting or it`s not a number')
  }

  del(`${HOST}${DELETE}/${id}`)
    .then(response => {
      const { data } = response

      if (data.status === SUCCESS) {
        onSuccess()
      } else {
        onError(data)
      }
    })
    .catch(err => {
      onError(err)
    })
}

export default {
  addTask,
  getList,
  delTask,
  updateTask
}
