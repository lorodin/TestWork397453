<template>
<div class="preloader" v-show="show">
  <div class="process" />
</div>
</template>

<script>
export default {
  name: 'Preloader',
  props: {
    show: Boolean
  }
}
</script>

<style lang="scss" scoped>
$progress-emoji: ('🕛','🕐','🕑','🕒','🕓','🕔','🕕','🕖','🕗','🕘','🕙','🕚') !default;

@mixin emojiLoader($emoji-list, $loader-name: emojiLoader, $step-duration: .08s, $prefix: '') {
  $emoji-count: length($emoji-list);
  $steps: $emoji-count - 1;
  content: $prefix nth($emoji-list, 1);
  animation: #{$loader-name} #{$step-duration * $emoji-count} steps(#{$steps}) infinite forwards 0s;

  @keyframes #{$loader-name} {
    @for $e from 1 through $emoji-count {
      $this-percentage: 100 / $emoji-count * ($e - 1);
      #{$this-percentage}% { content: $prefix nth($emoji-list, $e); }
    }
  }
}

.preloader {
  position: absolute;
  display: flex;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.6);
  justify-content: center;
  z-index: 1000;

  .process {
    display: flex;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);

    &::before {
      position: absolute;
      width: 1em;
      height: 1em;
      left: 50%;
      top: 50%;
      font-size: 4rem;
      text-align: center;
      transform: translate(-50%, -50%);
      @include emojiLoader($progress-emoji);
    }
  }
}
</style>
