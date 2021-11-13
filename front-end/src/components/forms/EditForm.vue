<template>
<div class="overflow">
  <div class="modal-form">
    <preloader :show="loading" />
    <div class="head">
      <span class="title">{{ task.id ? 'Edit' : 'Create' }} task</span>
      <span class="close-btn" title="close" @click="() => $emit('close')">❌</span>
    </div>
    <div class="body form">
      <ul class="errors">
        <li v-for="error in errors" :key="error">
          {{ parseError(error) }}
        </li>
      </ul>
      <div class="input-group">
        <label>Name</label>
        <input type="text" v-model="name" placeholder="name"/>
      </div>
      <div class="input-group">
        <label>Description</label>
        <textarea v-model="description" placeholder="description"></textarea>
      </div>
    </div>
    <div class="footer">
      <button @click="() => $emit('save', { id: id, name: name, description: description, completed: task.completed })">
        Save
      </button>
      <button @click="() => $emit('close')">
        Close
      </button>
    </div>
  </div>
</div>
</template>

<script>

import Preloader from '../common/Preloader'
export default {
  name: 'EditForm',
  components: { Preloader },
  emits: ['save', 'close'],
  props: {
    loading: Boolean,
    task: {
      type: Object
    },
    errors: {
      type: Array
    }
  },
  data () {
    return {
      id: this.task.id,
      name: this.task.name,
      description: this.task.description
    }
  },
  methods: {
    parseError: (error) => {
      switch (error) {
        case 'name': return 'Task name is required'
        case 'description': return 'Task description is required'
      }
      return 'Unknown error'
    }
  }
}
</script>

<style lang="scss" scoped>
@import "../../assets/scss/colors";

.modal-form {
  display: flex;
  position: absolute;
  flex-direction: column;
  background: #fff;
  border-radius: .4em;
  min-width: 320px;
  padding: 0;
  top: 50%;
  transform: translateY(-50%);

  @media screen and (max-width: 720px){
    width: 100%;
  }

  .head {
    display: flex;
    background: $color-dark;
    color: $color-light;
    border-top-left-radius: .4em;
    border-top-right-radius: .4em;
    padding: 0 .4em;
    line-height: 1.8em;
    justify-content: space-between;

    .close-btn {
      cursor: pointer;
    }
  }

  .footer {
    display: flex;
    justify-content: right;
    padding: .4em;

    button {
      margin-left: .4em;
    }
  }
}
</style>
