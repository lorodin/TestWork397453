<template>
  <div class="tasks-list">
    <div class="add-btn" @click="addTask" title="Add task">
      ➕ Add
    </div>
    <task-list-item
      v-for="task in list"
      :task="task"
      :key="task.id"
      @edit="editTask"
      @delete="delTask"
      @toggle-complete="toggleComplete"
    />
    <pagination :pages="pages"
                :current="current"
                @change="changePage" />
    <preloader :show="isLoading" />
  </div>
</template>

<script>
import TaskListItem from './TaskListItem'
import tasks from '../../stores/tasks'
import Pagination from './Pagination'
import Preloader from '../common/Preloader'

export default {
  name: 'TasksList',
  components: {
    Preloader,
    Pagination,
    TaskListItem
  },
  computed: {
    list: () => tasks.state.pageInfo.tasks,
    pages: () => tasks.state.pageInfo.pages,
    isLoading: () => tasks.state.pageInfo.loading,
    current: () => tasks.state.pageInfo.current
  },
  methods: {
    editTask: (id) => {
      tasks.openEditFormAction(id)
    },
    delTask: (id) => {
      if (confirm('Are you sure?')) {
        tasks.deleteTaskAction(id)
      }
    },
    addTask: () => {
      tasks.openEditFormAction()
    },
    changePage: (page) => {
      tasks.loadTasksAction({ page })
    },
    toggleComplete: (id) => {
      tasks.toggleCompleteAction(id)
    }
  }
}
</script>

<style lang="scss" scoped>
.tasks-list {
  position: relative;
  padding-bottom: 1em;

  .add-btn {
    text-align: center;
    width: 100%;
    height: 2.5em;
    font-size: 1.5em;
    background: #ccc;
    border-radius: .2em;
    line-height: 2.5em;
    cursor: pointer;
    transition: ease-in .15s;
    opacity: 0.7;

    &:hover {
      opacity: 1;
    }
  }
}
</style>
