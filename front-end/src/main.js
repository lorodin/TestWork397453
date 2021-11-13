import { createApp } from 'vue'
// import VueRouter from 'vue-router'
import { createRouter, createWebHistory } from 'vue-router'
import App from './App.vue'
import TasksView from './views/TasksView'
import LoginView from './views/LoginView'
import './assets/scss/main.scss'

const routes = [
  {
    path: '/',
    name: 'tasks',
    component: TasksView
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

createApp(App).use(router).mount('#app')
