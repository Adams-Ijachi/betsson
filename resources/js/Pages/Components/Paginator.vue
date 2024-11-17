
<template>
  <div class="mt-5">
    <template v-for="link in links">
      <Link
          class="p-1"
          :class="link.active ? 'font-bold' : ''"
          v-if="link.url"
          :href="link.url"
          v-html="link.label"
          preserve-state
      />
      <span v-else class="text-gray-500" v-html="link.label"></span>
    </template>

  </div>
</template>

<script>

import {Link} from "@inertiajs/vue3";

export default  {
  components: {Link},
  props:{
    links:Array
  }
}
</script>


<style scoped>

</style>