<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, computed, watch } from 'vue';
import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api';
const sellers = ref([]);
const currentPage = ref(1);
const itemsPerPage = 10;

onMounted(() => {
  getSellers();
});

const getSellers = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/sellers`);
    sellers.value = response.data;
  } catch (error) {
    console.error('Error fetching sellers:', error);
  }
};

const paginatedSellers = computed(() => {
  if (!Array.isArray(sellers.value.data)) {
    return [];
  }
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return sellers.value.data.slice(start, end);
});

const pageCount = computed(() => {
  if (!Array.isArray(sellers.value.data)) {
    return 0;
  }

  return Math.ceil(sellers.value.data.length / itemsPerPage);
});

const nextPage = () => {
  if (currentPage.value < pageCount.value) {
    currentPage.value++;
  }
};

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const goToPage = (page) => {
  currentPage.value = page;
};

const paginationPages = computed(() => {
  const range = 3; 
  const pages = [];
  const start = Math.max(1, currentPage.value - range);
  const end = Math.min(pageCount.value, currentPage.value + range);

  for (let i = start; i <= end; i++) {
    pages.push(i);
  }

  return pages;
});

const filter = ref('');

const filterSellers = () => {
    if (filter.value.trim() === '') {
        getSellers();
        return;
    }

  const filteredSellers = sellers.value.data.filter((seller) => {
    const searchTerm = filter.value.toLowerCase();
    return (
      seller.name.toLowerCase().includes(searchTerm) ||
      seller.email.toLowerCase().includes(searchTerm)
    );
  });
  sellers.value.data = filteredSellers;
  currentPage.value = 1;
};

const viewSeller = async (seller) => {
    try {
        const response = await axios.get(`${API_BASE_URL}/sellers/${seller.id}`);
        window.location.href = `/sellers/${seller.id}`;
    } catch (error) {
        console.error('Error fetching seller:', error);
    }
};

const editSeller = async (seller) => {
    try {
        const response = await axios.get(`${API_BASE_URL}/sellers/${seller.id}`);
        window.location.href = `/editSellers/${seller.id}`;
    } catch (error) {
        console.error('Error fetching seller:', error);
    }
};

const notification = ref(null);

const deleteSeller = async (sellerId) => {
    try {
        await axios.delete(`${API_BASE_URL}/sellers/${sellerId}`);
        notification.value = { type: 'success', message: 'Seller deleted successfully' };
        getSellers();
    } catch (error) {
        console.error('Error deleting seller:', error);
        notification.value = { type: 'error', message: 'Failed to delete seller' };
    }
};

watch(notification, (newVal) => {
    if (newVal) {
        setTimeout(() => {
            notification.value = null;
        }, 5000);
    }
});

</script>

<template>
  <Head title="Sellers" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sellers</h2>
    </template>
    <div v-if="notification" :class="['notification', notification.type]">
      {{ notification.message }}
    </div>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <input type="text" v-model="filter" @input="filterSellers" placeholder="Search..." class="mb-4 p-2 border border-gray-300 rounded-md" />

            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="seller in paginatedSellers" :key="seller.id">
                            <td class="border px-4 py-2">{{ seller.id }}</td>
                            <td class="border px-4 py-2">{{ seller.name }}</td>
                            <td class="border px-4 py-2">{{ seller.email }}</td>
                            <td class="border px-4 py-2">
                                <button @click="viewSeller(seller)" class="text-indigo-600 hover:text-indigo-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    View
                                </button>
                                <span class="mx-2"></span>
                                <button @click="editSeller(seller)" class="text-blue-600 hover:text-blue-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    Edit
                                </button>
                                <span class="mx-2"></span>
                                <button @click="deleteSeller(seller.id)" class="text-red-600 hover:text-red-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination">
                    <button class="waves-effect waves-light btn-small" @click="previousPage" :disabled="currentPage <= 1">Anterior</button>
                    <span v-for="page in pageCount" :key="page">
                        <button @click="goToPage(page)" :class="{ 'active': page === currentPage }">{{ page }}</button>
                    </span>
                    <button class="waves-effect waves-light btn-small" @click="nextPage" :disabled="currentPage >= pageCount">Próximo</button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<style>
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.pagination button {
  margin: 0 5px;
  padding: 5px 10px;
  border: 1px solid #ccc;
  background-color: #fff;
  cursor: pointer;
}

.pagination button.active {
  background-color: #007bff;
  color: #fff;
  border-color: #007bff;
}

.pagination button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.pagination i {
  margin-right: 5px;
}

.notification {
  position: fixed;
  top: 10px;
  right: 10px;
  padding: 10px;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: opacity 0.3s ease;
}

.notification.success {
  color: #155724;
  background-color: #d4edda;
  border-color: #c3e6cb;
}

.notification.error {
  color: #721c24;
  background-color: #f8d7da;
  border-color: #f5c6cb;
}

.notification-enter-active,
.notification-leave-active {
  transition: opacity 0.3s;
}

.notification-enter,
.notification-leave-to {
  opacity: 0;
}
</style>