<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  seller: {
    type: Object,
    required: true,
  },
});

const goBack = () => {
  window.history.back();
};
</script>

<template>
  <Head title="Sellers" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Seller Information</h2>
    </template>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Details of the seller:</h3>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">{{ seller.name }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">{{ seller.email }}</dd>
                        </div>
                        <!-- Outras informações do vendedor -->
                        </dl>
                    </div>
                </div>
            </div>
            <div class="mt-8">
                <a href="#" @click="goBack" class="text-indigo-600 hover:text-indigo-900">
                    &lt; Back
                </a>
            </div>
        </div>
    </div>
  </AuthenticatedLayout>
</template>