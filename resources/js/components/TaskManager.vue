<template>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Task Manager</h1>

    <div class="row mb-4">
      <div class="col-md-6">
        <input v-model="search" class="form-control" placeholder="Search tasks" @input="fetchTasks">
      </div>
      <div class="col-md-6">
        <select v-model="selectedCategory" class="form-control" @change="fetchTasks">
          <option value="">All Categories</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>
    </div>
    <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseForm">Add New Task</button>
  <div id="collapseForm" class="collapse">
        <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Add / Edit Task</h5>
            <div class="form-group">
            <input v-model="task.title" class="form-control mb-2" placeholder="Title">
            </div>
            <div class="form-group">
            <textarea v-model="task.description" class="form-control mb-2" placeholder="Description"></textarea>
            </div>
            <div class="form-row mb-2">
            <div class="col">
                <select v-model="task.status" class="form-control">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                </select>
            </div>
            <div class="col">
                <select v-model="task.category_id" class="form-control">
                <option value="">Select Category</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                </option>
                </select>
            </div>
            </div>
            <button class="btn btn-primary" @click="saveTask">Save Task</button>
        </div>
        </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Status</th>
          <th>Category</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in filteredTasks" :key="task.id">
          <td>{{ task.title }}</td>
          <td>{{ task.description }}</td>
          <td>{{ task.status }}</td>
          <td>{{ task.category.name }}</td>
          <td>
            <button class="btn btn-secondary btn-sm mr-2" @click="editTask(task)">Edit</button>
            <button class="btn btn-danger btn-sm" @click="deleteTask(task.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      tasks: [],
      task: {
        title: '',
        description: '',
        status: 'pending',
        category_id: ''
      },
      categories: [],
      search: '',
      selectedCategory: ''
    };
  },
  computed: {
    filteredTasks() {
      return this.tasks.filter(task => {
        return (this.search === '' || task.title.includes(this.search)) &&
               (this.selectedCategory === '' || task.category_id === parseInt(this.selectedCategory));
      });
    }
  },
  mounted() {
    this.fetchTasks();
    this.fetchCategories();
  },
  methods: {
    fetchTasks() {
      axios.get('/api/tasks', {
        params: {
          search: this.search,
          category: this.selectedCategory
        }
      })
      .then(response => {
        this.tasks = response.data;
      })
      .catch(error => {
        console.error(error);
      });
    },
    fetchCategories() {
      axios.get('/api/categories')
      .then(response => {
        this.categories = response.data;
      })
      .catch(error => {
        console.error(error);
      });
    },
    saveTask() {
      const method = this.task.id ? 'put' : 'post';
      const url = this.task.id ? `/api/tasks/${this.task.id}` : '/api/tasks';
      axios[method](url, this.task)
      .then(response => {
        this.fetchTasks();
        this.resetTask();
      })
      .catch(error => {
        console.error(error);
      });
    },
    editTask(task) {
      this.task = { ...task };
    },
    deleteTask(id) {
      axios.delete(`/api/tasks/${id}`)
      .then(response => {
        this.fetchTasks();
      })
      .catch(error => {
        console.error(error);
      });
    },
    resetTask() {
      this.task = {
        title: '',
        description: '',
        status: 'pending',
        category_id: ''
      };
    }
  }
};
</script>

<style scoped>
/* Add your custom styles here if necessary */
</style>
