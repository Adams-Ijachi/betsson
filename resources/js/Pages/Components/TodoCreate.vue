
<template>
  <div>
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Add New Task</h2>
    <form class="space-y-4" @submit.prevent="$emit('handleSubmit')">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Task Name</label>
        <input

            v-model="form.name"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Enter task name"
        >

      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
          <select
              required
              v-model="form.label_id"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          >
            <option disabled value="">Please select one</option>
            <option v-for="label in labels" :key="label.id" :value="label.id"  v-text="label.name"></option>
          </select>

        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
          <select
              required
              v-model="form.priority_id"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          >
            <option disabled value="">Please select one</option>
            <option v-for="priority in priorities" :key="priority.id"  :value="priority.id" v-text="priority.name"></option>

          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Assign Under</label>
          <select

              v-model="form.parent_id"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          >
            <option disabled value="">Please select one</option>
            <option v-for="todo in all_users_todos" :key="todo.id"  :value="todo.id" v-text="todo.name"></option>

          </select>
        </div>
      </div>

      <button
          type="submit"
          v-text="form.processing ? 'Processing...' : 'Add Task' "
          :disabled="form.processing"
          class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-200"
          :class="{
              'bg-blue-100' : form.processing
            }"
      >

      </button>
    </form>
  </div>




</template>
<script setup>

  defineEmits(['handleSubmit']);

  defineProps({
    labels:Array,
    priorities:Array,
    all_users_todos:Array,
    form: {
      type:Object,
      required:true
    }
  })

</script>
