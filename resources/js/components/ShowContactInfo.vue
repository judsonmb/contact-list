<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-96">
      <h2 class="text-2xl font-semibold text-center mb-4">Informações do Contato</h2>
      
      <p><strong>Nome:</strong> {{ contact.name }}</p>
      <p><strong>Email:</strong> {{ contact.email }}</p>
      <p><strong>Telefone:</strong> {{ contact.phone }}</p>
      <p><strong>CEP:</strong> {{ contact.postal_code }}</p>
      <p><strong>Estado:</strong> {{ contact.state }}</p>
      <p><strong>Cidade:</strong> {{ contact.city }}</p>
      <p><strong>Bairro:</strong> {{ contact.district }}</p>
      <p><strong>Endereço:</strong> {{ contact.address }}</p>
      <p><strong>Número:</strong> {{ contact.number }}</p>

      <div class="mt-4 text-center">
        <button @click="$emit('close')" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Fechar</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    contact: Object,
  },
};
</script>
