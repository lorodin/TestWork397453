<template>
  <div class="task-list-item" :class="{complete: task.completed}">
    <div class="body">
      <div class="name">
        <h4>{{task.name}}</h4>
      </div>
      <div class="description">
        {{task.description}}
      </div>
    </div>
    <div class="actions" v-if="!task.completed">
      <button class="complete-btn" @click="() => $emit('toggle-complete', task.id)" title="Check as complete">
        ✔️
      </button>
      <button class="edit" @click="() => $emit('edit', task.id)" title="Edit task">
        ✒️
      </button>
      <button class="delete" @click="() => $emit('delete', task.id)" title="Remove task">
        🗑️
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TaskListItem',
  emits: ['edit', 'delete', 'toggle-complete'],
  props: {
    task: Object
  }
}
</script>

<style lang="scss" scoped>
@import "../../assets/scss/colors";

.task-list-item {
  display: flex;
  justify-content: space-between;
  padding: .5em;
  border-radius: .5em;
  margin: .3em 0;
  background: $color-warning;

  &.complete {
    background:$color-success;
  }

  .name h4 {
    padding: 0;
    margin: 0 0 0.5em;
  }

  .description {
    text-align: justify;
  }

  .actions {
    display: flex;

    button {
      height: 3em;
      width: 3em;
      line-height: 3em;
      margin-left: .3em;
      background: rgba(255, 255, 255, 0.6);
      border: 0;
      border-radius: .4em;
      cursor: pointer;
      transition: ease-in .15s;

      &:hover {
        background: rgba(255, 255, 255, 1);
      }
    }
  }

}
</style>
