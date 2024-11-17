
<template>
  <div class="m-5">
    <h3 class="text-2xl mb-5">Filters By</h3>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
      <div class="flex flex-wrap gap-2">
        <button
            @click="$emit('applyFilter','priority','')"
            type="button"
            class="px-3 py-1 rounded-full text-sm font-medium "
            :class="{
                  'bg-blue-500 text-white': priorityFilter === ''
                }"
        >
          All
        </button>
        <button
            @click="$emit('applyFilter','priority',priority.id)"
            type="button"
            class="px-3 py-1 rounded-full text-sm font-medium  "
            :class="{
                  'bg-blue-500 text-white': priorityFilter === priority.id,

                }"
            v-for="priority in priorities"
            v-text=" priority.name"
        >
        </button>

      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Labels</label>
      <div class="flex flex-wrap gap-2">
        <button

            @click="$emit('applyFilter','category','')"
            type="button"
            class="px-3 py-1 rounded-full text-sm font-medium "
            :class="{
                  'bg-blue-500 text-white': labelFilter === ''
                }"
        >
          All
        </button>
        <button
            @click="$emit('applyFilter','category',label.id)"
            type="button"
            class="px-3 py-1 rounded-full text-sm font-medium  "
            :class="{
                  'bg-blue-500 text-white': labelFilter === label.id,

                }"
            v-for="label in labels"
            v-text=" label.name"
        >
        </button>

      </div>
    </div>
  </div>
</template>

<script setup>


  defineProps({
    labels:Array,
    priorities:Array,
    priorityFilter:String,
    labelFilter:String
  })


</script>

<style scoped>

</style>