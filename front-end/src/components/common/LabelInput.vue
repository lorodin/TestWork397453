<template>
<div class="input-group">
  <label>{{label}}</label>
  <input v-if="type !== 'textarea'"
         :class="{fail: errors.length !== 0}"
         :type="type"
         :value="modelValue"
         :placeholder="placeholder"
         @input="(e) => $emit('input', e.target.value)"/>
  <textarea v-else @input="(e) => $emit('input', e.target.value)"
            :class="{fail: errors.length !== 0}"
            :value="modelValue"
            :placeholder="placeholder"
  >
  </textarea>
  <ul v-if="errors.length !== 0" class="errors">
    <li v-for="err in errors" :key="err">
      {{err}}
    </li>
  </ul>
</div>
</template>

<script>
export default {
  name: 'LabelInput',
  emits: ['input'],
  props: {
    modelValue: {
      type: String
    },
    label: {
      type: String
    },
    type: {
      type: String
    },
    placeholder: {
      type: String
    },
    errors: {
      type: Array,
      default: () => []
    }
  }
}
</script>

<style scoped>
.input-group textarea {
  resize: none;
  height: 4em;
}
</style>
