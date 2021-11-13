<template>
  <ul class="pagination">
    <li v-for="page in pagesList"
        :key="page.number + page.text"
        :class="{ active: current === page.number }"
        @click="() => $emit('change', page.number)">
      {{page.text}}
    </li>
  </ul>
</template>

<script>
export default {
  name: 'Pagination',
  emits: ['change'],
  props: {
    pages: {
      type: Number
    },
    current: {
      type: Number
    },
    linksLimit: {
      type: Number,
      default: 5
    }
  },
  computed: {
    pagesList: function () {
      if (this.pages <= 1) {
        return []
      }

      const pages = []

      if (this.current !== 1) {
        pages.push({
          number: this.current - 1,
          text: '<'
        })
      }

      let left
      let right

      if (this.pages <= this.linksLimit) {
        left = 0
        right = this.pages
      } else if (this.current < this.linksLimit && this.linksLimit < this.pages) {
        right = this.linksLimit + 1
      } else if (this.current > this.pages - this.linksLimit) {
        left = this.pages - this.linksLimit - 1
      } else {
        left = this.current - Math.floor(this.linksLimit / 2) - 1
        if (this.pages > this.current + Math.floor(this.linksLimit / 2) + 1) {
          right = this.current + Math.floor(this.linksLimit / 2) + 1
        }
      }

      if (left > 0) {
        pages.push({
          number: left + 1,
          text: '...'
        })
      }

      while (left < Math.min(this.pages, right)) {
        pages.push({
          number: left + 1,
          text: `${left + 1}`
        })
        left++
      }

      if (right + 1 < this.pages) {
        pages.push({
          number: right + 1,
          text: '...'
        })
      }

      if (this.current !== this.pages) {
        pages.push({
          number: this.current + 1,
          text: '>'
        })
      }

      return pages
    }
  }
}
</script>

<style lang="scss" scoped>
@import "../../assets/scss/colors";

.pagination {
  display: flex;
  justify-content: center;
  padding: .4em 0;
  margin: 0;
  list-style: none;

  li {
    margin-left: .4em;
    color: $color-blue;
    cursor: pointer;

    &.active {
      color: $color-dark;
    }

    &:hover {
      text-decoration: underline;
    }
  }
}
</style>
