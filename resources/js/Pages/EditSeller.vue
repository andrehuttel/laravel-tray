<script setup>
import { ref, defineProps } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    seller: {
        type: Object,
        required: true,
    },
    onSuccess: {
        type: Function,
        required: true,
    },
    onCancel: {
        type: Function,
        required: true,
    }
});

const editedSeller = ref({ ...props.seller });
console.log(editedSeller.value);
const API_BASE_URL = 'http://localhost:8000/api';
const updateSeller = async () => {
    try {
        await axios.put(`${API_BASE_URL}/sellers/${editedSeller.value.id}`, editedSeller.value);
        window.location.href = `/sellers`;
    } catch (error) {
        console.error('Error updating seller:', error);
        //toast.error('Failed to update seller');
    }
};

const cancelEdit = () => {
    props.onCancel(); // Chamada de volta para cancelar a edição e voltar à lista de vendedores
};
</script>

<template>
    <Head title="Sellers" />
  
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Seller</h2>
      </template>
  
      <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                  <form @submit.prevent="updateSeller" class="space-y-6">
                      <div>
                          <label for="name" class="block font-medium text-gray-700">Name:</label>
                          <input type="text" id="name" v-model="editedSeller.name" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                      </div>
                      <div>
                          <label for="email" class="block font-medium text-gray-700">Email:</label>
                          <input type="email" id="email" v-model="editedSeller.email" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                      </div>
                      <div class="flex justify-end">
                          <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                              Save
                          </button>
                          <button type="button" @click="cancelEdit" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                              Cancel
                          </button>
                      </div>
                  </form>
              </div>
              <div class="mt-8">
                  <a href="#" @click="goBack" class="text-indigo-600 hover:text-indigo-900">&lt; Back</a>
              </div>
          </div>
      </div>
    </AuthenticatedLayout>
</template>
  
<style>
  /* Estilos para o formulário (pode ser ajustado conforme sua necessidade) */
  form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
  
  label {
    font-weight: bold;
  }
  
  input {
    padding: 0.5rem;
    border-radius: 4px;
    border: 1px solid #ccc;
  }
  
  button {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    border: none;
    cursor: pointer;
  }
  
  button[type="submit"] {
    background-color: #007bff;
    color: #fff;
  }
  
  button[type="submit"]:hover {
    background-color: #0056b3;
  }
</style>
  