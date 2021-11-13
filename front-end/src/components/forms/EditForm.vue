<template>
<div class="overflow">
  <div class="modal-form">
    <preloader :show="loading" />
    <div class="head">
      <span class="title">{{ task.id ? 'Edit' : 'Create' }} task</span>
    </div>
    <div class="body form">
      <label-input v-model="name"
                   label="Name"
                   placeholder="name"
                   :errors="errors.name || []"
                   @input="(val) => this.name = val" />
      <label-input v-model="description"
                   label="Description"
                   type="textarea"
                   placeholder="description"
                   :errors="errors.description || []"
                   @input="(val) => this.description = val" />
    </div>
    <div class="footer">
      <button class="btn btn-success" @click="() => $emit('save', { id: id, name: name, description: description, completed: task.completed })">
        Save
      </button>
      <button class="btn btn-danger" @click="() => $emit('close')">
        Close
      </button>
    </div>
  </div>
</div>
</template>

<script>

import Preloader from '../common/Preloader'
import LabelInput from '../common/LabelInput'
export default {
  name: 'EditForm',
  components: { LabelInput, Preloader },
  emits: ['save', 'close'],
  props: {
    loading: Boolean,
    task: {
      type: Object
    },
    errors: {
      type: Object
    }
  },
  data () {
    return {
      id: this.task.id,
      name: this.task.name || '',
      description: this.task.description,
      errs2: []
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
  min-width: 320px;
  padding: 0;
  top: 50%;
  transform: translateY(-50%);

  @media screen and (max-width: 720px){
    width: 100%;
  }

  .head {
    border-bottom: 1px solid $color-gray;
    padding: 1em .5em .5em;
    line-height: 1.8em;
  }

  textarea {
    resize: none;
    min-height: 100px;
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
