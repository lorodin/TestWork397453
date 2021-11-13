<template>
<div class="page content-center">
  <div class="login-form">
    <preloader :show="loading" />
    <div class="head">
      {{ loginAction ? 'Login' : 'Register' }}
    </div>
    <div v-if="loginAction" class="body form">
      <ul v-if="hasError('login')" class="errors">
        <li v-for="err in errors.login" :key="err">
          {{ err }}
        </li>
      </ul>
      <div class="input-group">
        <label>Email</label>
        <input v-model="email" type="email" placeholder="email" :class="{fail: hasError('email')}">
        <ul v-if="hasError('email')" class="errors">
          <li v-for="err in errors.email" :key="err">
            {{ err }}
          </li>
        </ul>
      </div>
      <div class="input-group">
        <label>Password</label>
        <input v-model="password" type="password" placeholder="password" :class="{fail: hasError('password')}">
        <ul v-if="hasError('password')" class="errors">
          <li v-for="err in errors.password" :key="err">
            {{ err }}
          </li>
        </ul>
      </div>
    </div>
    <div v-else class="body form">
      <div class="input-group">
        <label>Name</label>
        <input v-model="name" type="text" placeholder="name" :class="{fail: hasError('name')}">
        <ul v-if="hasError('name')" class="errors">
          <li v-for="err in errors.name" :key="err">
            {{ err }}
          </li>
        </ul>
      </div>
      <div class="input-group">
        <label>Email</label>
        <input v-model="email" type="email" placeholder="email" :class="{fail: hasError('email')}">
        <ul v-if="hasError('email')" class="errors">
          <li v-for="err in errors.email" :key="err">
            {{ err }}
          </li>
        </ul>
      </div>
      <div class="input-group">
        <label>Password</label>
        <input v-model="password" type="password" placeholder="password" :class="{fail: hasError('password')}">
        <ul v-if="hasError('password')" class="errors">
          <li v-for="err in errors.password" :key="err">
            {{ err }}
          </li>
        </ul>
      </div>
      <div class="input-group">
        <label>Confirm password</label>
        <input v-model="confirm" type="password" placeholder="confirm password" :class="{fail: hasError('confirm')}"/>
        <ul v-if="hasError('confirm')" class="errors">
          <li v-for="err in errors.confirm" :key="err">
            {{ err }}
          </li>
        </ul>
      </div>
    </div>
    <div class="footer">
      <div>
        <span @click="loginAction = !loginAction">
          {{loginAction ? 'Register' : 'Login'}}
        </span>
      </div>
      <div class="actions">
        <button @click="action">
          {{loginAction ? 'Login' : 'Register'}}
        </button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import tasks from '../stores/tasks'
import Preloader from '../components/common/Preloader'

export default {
  name: 'LoginView',
  components: { Preloader },
  data () {
    return {
      loginAction: true,
      name: '',
      email: '',
      password: '',
      confirm: ''
    }
  },
  computed: {
    loading: () => tasks.state.login.loading,
    errors: () => tasks.state.login.errors
  },
  methods: {
    hasError (err) {
      return this.errors && !!this.errors[err]
    },
    action () {
      if (this.loginAction) {
        tasks.loginAction({
          email: this.email,
          password: this.password
        })
      } else {
        tasks.registerAction({
          name: this.name,
          email: this.email,
          password: this.password,
          confirm: this.confirm
        })
      }
    }
  }
}
</script>

<style scoped>
.login-form {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
}
</style>
