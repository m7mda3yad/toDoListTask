<template>
    <div class="container">
      <h1>Task List</h1>
      <form @submit.prevent="addTask">
        <div class="form-group">
          <input v-model="newTask.title" type="text" class="form-control" placeholder="Task Title" required />
        </div>
        <div class="form-group">
          <textarea v-model="newTask.description" class="form-control" placeholder="Task Description"></textarea>
        </div>
        <div class="form-group">
            <input v-model="newTask.due_date" type="date" class="form-control mt-3" />
        </div>
        <div class="form-group">
          <select v-model="newTask.status" class="form-control">
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Task</button>
      </form>
            <select v-model="filterStatus" class="form-control mt-3">
        <option value="">All</option>
        <option value="pending">Pending</option>
        <option value="completed">Completed</option>
        </select>

      <input v-model="search" type="text" class="form-control mt-3" placeholder="Search tasks..." />
      
      <table class="table mt-3">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="task in filteredTasks" :key="task.id">
            <td>{{ task.title }}</td>
            <td>{{ task.description }}</td>
            <td>{{ task.due_date ? new Date(task.due_date).toLocaleDateString() : 'N/A' }}</td>
            <td>{{ task.status }}</td>
            <td>
              <button @click="editTask(task)" class="btn btn-warning">Edit</button>
              <button @click="deleteTask(task.id)" class="btn btn-danger">Delete</button>
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
        newTask: {
          title: '',
          description: '',
          status: 'pending'
        },
        search: '',
      };
    },
    computed: {
        filteredTasks() {
  return this.tasks
    .filter(task => {
      return task.title.toLowerCase().includes(this.search.toLowerCase()) ||
             task.description.toLowerCase().includes(this.search.toLowerCase());
    })
    .filter(task => {
      return this.filterStatus === '' || task.status === this.filterStatus;
    });
}

    },
    methods: {
      async fetchTasks() {
        try {
          const response = await axios.get('/api/tasks');
          this.tasks = response.data;
        } catch (error) {
          console.error(error);
        }
      },
      async addTask() {
        try {
          const response = await axios.post('/api/tasks', this.newTask);
          this.tasks.push(response.data);
          this.newTask = { title: '', description: '', status: 'pending' };
        } catch (error) {
          console.error(error);
        }
      },
      async editTask(task) {
        // Implement edit functionality
      },
      async deleteTask(id) {
        try {
          await axios.delete(`/api/tasks/${id}`);
          this.tasks = this.tasks.filter(task => task.id !== id);
        } catch (error) {
          console.error(error);
        }
      }
    },
    mounted() {
      this.fetchTasks();
    }
  };
  </script>
  
  <style scoped>
  /* Add your custom styling here */
  </style>
  