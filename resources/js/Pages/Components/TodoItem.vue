
<template>
  <div class="border border-gray-200 rounded-lg p-4 m-2"  v-for="todo in todos" :key="todo.id">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <input
            @click="handleCheckToggle(todo.id)"
            :checked="todo.is_completed"
            type="checkbox"
            :value="todo.id"
            class="h-5 w-5 text-blue-500"
        >

        <!--        Name-->
        <span v-text="todo.name"
              :class="{
                  'line-through': todo.is_completed,
                  'text-gray-500': todo.is_completed,
                  'font-medium':  !todo.is_completed
                }" ></span>
      </div>

      <!--      Priority -->
      <div class="flex items-center space-x-2">

        <span  :class="{
              'bg-green-100 text-green-800': todo.priority.name === 'low',
              'bg-yellow-100 text-yellow-800': todo.priority.name === 'medium',
              'bg-red-100 text-red-800': todo.priority.name === 'high'
            }"
              class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"
              v-text="todo.priority.name"></span>
      </div>
    </div>

    <div class="flex flex-wrap gap-2 mt-2">
      <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs" v-text="todo.category.name">
      </span>


    </div>

    <!-- Child Task -->
    <!-- Recursive Children -->
    <span @click="toggleOpen(todo.id)" class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs cursor-pointer" v-if="todo.children.length" >
        {{ isOpen(todo.id) ? 'Close' : 'Open' }} ({{ todo.children.length }})
    </span>

    <div v-if="todo.children?.length && isOpen(todo.id)"   class="ml-8 mt-4">
      <TodoItem :todos="todo.children" @handle-checked="handleCheckToggle" />
    </div>

  </div>
</template>

<script setup>
import { ref } from 'vue';


defineProps({ todos:Array});
const emit = defineEmits(['handleChecked']);


const open = ref(false);

const checkedTask = ref([]);

// Create a Map to store the open state for each todo item
const openStates = ref(new Map())

// Toggle function that uses the todo's ID as a key
const toggleOpen = (todoId) => {
  openStates.value.set(todoId, !openStates.value.get(todoId))
}
// Handle toggle for current level
const handleCheckToggle = (todoId) => {
  emit('handleChecked', todoId);
}

const isChecked = (todoId) => {
  return checkedTask.value.includes(todoId)

}

// Helper function to check if a specific todo is open
const isOpen = (todoId) => {
  return openStates.value.get(todoId) || false
}
</script>

<style scoped>

</style>