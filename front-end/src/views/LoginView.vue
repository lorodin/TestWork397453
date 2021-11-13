<template>
<div class="page content-center">
  <div class="login-form">
    <preloader :show="loading" />
    <div class="head">
      {{ loginAction ? 'Login' : 'Register' }}
    </div>
    <div v-if="loginAction" class="body form">
      <ul v-if="errors.login && errors.login.length > 0" class="errors">
        <li v-for="err in errors.login" :key="err">
          {{ err }}
        </li>
      </ul>
      <label-input v-model="email"
                   :errors="errors.email || []"
                   type="email"
                   label="Email"
                   placeholder="email"
                   @input="val => this.email = val" />
      <label-input v-model="password"
                   :errors="errors.password || []"
                   type="password"
                   label="Password"
                   placeholder="password"
                   @input="val => this.password = val" />
    </div>
    <div v-else class="body form">
      <label-input v-model="name"
                   :errors="errors.name || []"
                   type="name"
                   label="Name"
                   placeholder="name"
                   @input="val => this.name = val" />
      <label-input v-model="email"
                   :errors="errors.email || []"
                   type="email"
                   label="Email"
                   placeholder="email"
                   @input="val => this.email = val" />
      <label-input v-model="password"
                   :errors="errors.password || []"
                   type="password"
                   label="Password"
                   placeholder="password"
                   @input="val => this.password = val" />
      <label-input v-model="confirm"
                   :errors="errors.confirm || []"
                   type="password"
                   label="Confirm password"
                   placeholder="password"
                   @input="val => this.confirm = val" />
    </div>
    <div class="footer">
      <div>
        <span @click="loginAction = !loginAction" class="link">
          {{loginAction ? 'Register' : 'Login'}}
        </span>
      </div>
      <div class="actions">
        <button @click="action" class="btn">
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
import LabelInput from '../components/common/LabelInput'

export default {
  name: 'LoginView',
  components: { LabelInput, Preloader },
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

<style lang="scss" scoped>
@import "../assets/scss/colors";

.login-form {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  border: 1px solid $color-gray;
  min-width: 300px;

  .head {
    border-bottom: 1px solid $color-gray;
    padding: 1em 1em .5em;
  }

  .body .errors {
    padding-top: .6em;
  }

  .footer {
    display: flex;
    justify-content: space-between;
    padding: .5em;
    line-height: 1.6em;
  }
}
</style>
