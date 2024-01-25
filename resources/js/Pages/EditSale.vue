<script setup>
import { ref, defineProps } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    sale: {
        type: Object,
        required: true,
    }
});

const editedSale = ref({ ...props.sale });
const API_BASE_URL = 'http://localhost:8000/api';
const updateSale = async () => {
    try {
        await axios.put(`${API_BASE_URL}/sales/${editedSale.value.id}`, editedSale.value);
        window.location.href = `/sales`;
    } catch (error) {
        console.error('Error updating sale:', error);
    }
};

const goBack = () => {
  window.history.back();
};

</script>

<template>
    <Head title="Sales" />
  
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Sale</h2>
      </template>
  
      <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                  <form @submit.prevent="updateSale" class="space-y-6">
                      <div>
                          <label for="seller_id" class="block font-medium text-gray-700">Seller ID:</label>
                          <input type="number" id="seller_id" v-model="editedSale.seller_id" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                      </div>
                      <div>
                          <label for="value" class="block font-medium text-gray-700">Value:</label>
                          <input type="number" step="any" id="value" v-model="editedSale.value" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                      </div>
                      <div>
                          <label for="commission" class="block font-medium text-gray-700">Commission:</label>
                          <input disabled type="number" step="any" id="commission" v-model="editedSale.commission" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                      </div>
                      <div>
                          <label for="sale_date" class="block font-medium text-gray-700">Sale Date:</label>
                          <input type="date" id="sale_date" v-model="editedSale.sale_date" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                      </div>
                      <div class="flex justify-end">
                          <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                              Save
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
  