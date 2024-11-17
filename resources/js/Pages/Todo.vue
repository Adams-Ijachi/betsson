<!-- TodoList.vue -->
<template>
  <div class="container mx-auto p-6 max-w-4xl">
    <!-- Add Task Form -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">

        <TodoCreate
            :form="form"
            :priorities="priorities"
            :labels="labels"
            :todos="todos.data"
            :all_users_todos="all_users_todos"
            @handle-submit="handleSubmit"
        />


      <FilterList
          :label-filter="labelFilter"
          :priority-filter="priorityFilter"

          :labels="labels"
          :priorities="priorities"
          @apply-filter="applyFilter"

      />

    <!-- Task List -->
    <div class="bg-white rounded-lg shadow-md p-6">
      <h2 class="text-2xl font-bold mb-4 text-gray-800">Tasks</h2>
      <div class="space-y-4">
        <!-- Parent Task -->
        <TodoItem  :todos="todos.data" @handle-checked="handleChecked" v-if="!loading"  />

        <div v-else class="bg-white rounded-lg shadow-md p-6 animate-pulse">
          <div class="h-8 bg-gray-200 rounded w-1/4 mb-4"></div>
          <!-- Skeleton items -->
          <div class="space-y-4">
            <div v-for="n in 3" :key="n" class="flex items-center gap-3">
              <div class="h-4 w-4 bg-gray-200 rounded"></div>
              <div class="h-4 bg-gray-200 rounded w-3/4"></div>
            </div>
            <!-- Nested items -->
            <div class="pl-8 space-y-4">
              <div v-for="n in 2" :key="`nested-${n}`" class="flex items-center gap-3">
                <div class="h-4 w-4 bg-gray-200 rounded"></div>
                <div class="h-4 bg-gray-200 rounded w-2/3"></div>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>


    <!--  Paginator-->
    <Paginator :links="todos.meta.links"/>
  </div>

  </div>

</template>

<script setup>

  import {ref, reactive,watch} from "vue";
  import { toast } from 'vue3-toastify';
  import 'vue3-toastify/dist/index.css';
  import { usePage } from '@inertiajs/vue3';
  import {router,useForm} from "@inertiajs/vue3";
  import TodoItem from "./Components/TodoItem.vue";
  import Paginator from "./Components/Paginator.vue";
  import TodoCreate from "./Components/TodoCreate.vue";
  import FilterList from "./Components/FilterList.vue";


  const params = reactive({});
  const priorityFilter = ref('');
  const labelFilter = ref('');
  const loading = ref(false)


  let form = useForm({
    name:"",
    label_id:"",
    priority_id:"",
    parent_id:""
  });

  const applyFilter = (key, value) => {

    if (value) {

      params[key] = value;
    } else {
      delete params[key];
    }

    if (key === 'category') {
      labelFilter.value = value;
    } else if (key === 'priority') {
      priorityFilter.value = value;
    }

    router.get('/todo', {...params}, { preserveState: true,replace:true });
  };

  const handleSubmit = () => {
    form.post('/todo',{
      onSuccess: () => {
        form.reset()
        const toasts = usePage()?.props?.flash.toasts;
        toast.success(toasts.message)
      },
      onError: (errors) =>{
        Object.entries(errors).forEach(([key, message]) => {
          toast.error(message);
        });
      },
      preserveState:true
    })
  }

  watch(
      // NOTE: Since Inertia.js 1.0.1, usePage() may return null initially.
      () => usePage()?.props?.errors,
      (newToasts) => {
        if(!newToasts.message) return
        toast.error(newToasts.message);
      }
  )

  const handleChecked = (todoID) =>{
    loading.value = true;
    router.patch(`todo/${todoID}`,{},{
      onSuccess : () =>{
        loading.value = false;
        const toasts = usePage()?.props?.flash.toasts;
        toast.success(toasts.message)
      },
      onError: (errors) =>{
        loading.value = false;
    },
      preserveState:true,
      preserveScroll:true
    });


  }

  defineProps({
    todos:Object,
    labels:Array,
    priorities:Array,
    all_users_todos:Array
  });

</script>