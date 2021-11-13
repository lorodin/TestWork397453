<template>
  <div class="notify" :class="{show: message && message !== ''}">
    {{ message }}
  </div>
</template>

<script>
export default {
  name: 'Notify',
  props: {
    message: {
      type: [String, null]
    }
  }
}
</script>

<style lang="scss" scoped>
  .notify {
    position: absolute;
    right: 0;
    top: 0;
    min-width: 200px;
    padding: .5em;
    border-radius: .2em;
    background: #28a745!important;
    color: #fff;
    transition: .15s ease-in;
    opacity: 0;

    &.show {
      opacity: 1;
    }
  }
</style>
