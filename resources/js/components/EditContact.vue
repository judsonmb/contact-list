<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-96">
      <h2 class="text-2xl font-semibold text-center mb-4">Editar Contato</h2>

      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1" for="name">Nome</label>
          <input 
            type="text" 
            v-model="contact.name" 
            id="name" 
            required 
            class="w-full border border-gray-300 rounded-md px-4 py-2"/>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1" for="email">Email</label>
          <input 
            type="email" 
            v-model="contact.email" 
            id="email" 
            required 
            class="w-full border border-gray-300 rounded-md px-4 py-2"/>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1" for="phone">Telefone</label>
          <input 
            type="text" 
            v-model="contact.phone" 
            id="phone" 
            required 
            class="w-full border border-gray-300 rounded-md px-4 py-2"/>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1" for="postal_code">CEP</label>
          <input 
            type="text" 
            v-model="contact.postal_code" 
            id="postal_code" 
            required 
            class="w-full border border-gray-300 rounded-md px-4 py-2"
            @blur="fetchAddress"/>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1" for="state">Estado</label>
          <select 
            v-model="contact.state"
            id="state" 
            required 
            class="w-full border border-gray-300 rounded-md px-4 py-2">
            <option value="" disabled>Selecione o estado</option>
            <option v-for="(state, index) in states" :key="index" :value="state.uf">
              {{ state.nome }}
            </option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1" for="city">Cidade</label>
          <input 
            type="text" 
            v-model="contact.city" 
            id="city" 
            class="w-full border border-gray-300 rounded-md px-4 py-2"/>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1" for="address">Endereço</label>
          <input 
            type="text" 
            v-model="contact.address" 
            id="address" 
            class="w-full border border-gray-300 rounded-md px-4 py-2"/>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1" for="number">Número</label>
          <input 
            type="text" 
            v-model="contact.number" 
            id="number" 
            class="w-full border border-gray-300 rounded-md px-4 py-2"/>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1" for="district">Bairro</label>
          <input 
            type="text" 
            v-model="contact.district" 
            id="district" 
            class="w-full border border-gray-300 rounded-md px-4 py-2"/>
        </div>

        <div class="mt-4 text-center">
          <button 
            type="submit" 
            :disabled="loading" 
            class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 disabled:opacity-50">
            {{ loading ? 'Carregando...' : 'Salvar' }}
          </button>
          <button 
            @click="$emit('close')" 
            class="ml-2 bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">
            Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    contact: Object,
  },
  data() {
    return {
      loading: false,
      states: [
        { uf: 'AC', nome: 'Acre' },
        { uf: 'AL', nome: 'Alagoas' },
        { uf: 'AM', nome: 'Amazonas' },
        { uf: 'BA', nome: 'Bahia' },
        { uf: 'CE', nome: 'Ceará' },
        { uf: 'ES', nome: 'Espírito Santo' },
        { uf: 'GO', nome: 'Goiás' },
        { uf: 'MA', nome: 'Maranhão' },
        { uf: 'MT', nome: 'Mato Grosso' },
        { uf: 'MS', nome: 'Mato Grosso do Sul' },
        { uf: 'MG', nome: 'Minas Gerais' },
        { uf: 'PA', nome: 'Pará' },
        { uf: 'PB', nome: 'Paraíba' },
        { uf: 'PR', nome: 'Paraná' },
        { uf: 'PE', nome: 'Pernambuco' },
        { uf: 'PI', nome: 'Piauí' },
        { uf: 'RJ', nome: 'Rio de Janeiro' },
        { uf: 'RN', nome: 'Rio Grande do Norte' },
        { uf: 'RS', nome: 'Rio Grande do Sul' },
        { uf: 'RO', nome: 'Rondônia' },
        { uf: 'RR', nome: 'Roraima' },
        { uf: 'SC', nome: 'Santa Catarina' },
        { uf: 'SP', nome: 'São Paulo' },
        { uf: 'SE', nome: 'Sergipe' },
        { uf: 'TO', nome: 'Tocantins' }
      ]
    };
  },
  methods: {
    async submitForm() {
      this.loading = true;
      document.body.style.cursor = 'wait';
      
      try {
        await axios.put(`/api/contacts/${this.contact.id}`, this.contact);
        this.$emit('close');
        this.$emit('reload');
      } catch (error) {
        if (error.response && error.response.data.errors?.email) {
          alert(error.response.data.errors.email[0]);
        } else {
          console.error('Erro ao editar o contato', error);
        }
      } finally {
        this.loading = false;
        document.body.style.cursor = 'default';
      }
    },

    async fetchAddress() {
      if (this.contact.postal_code.length === 8) {
        try {
          const response = await axios.get(`https://viacep.com.br/ws/${this.contact.postal_code}/json/`);
          if (response.data) {
            this.contact.address = response.data.logradouro;
            this.contact.number = '';
            this.contact.district = response.data.bairro;
            this.contact.city = response.data.localidade;
            this.contact.state = response.data.uf;
          }
        } catch (error) {
          console.error('Erro ao buscar o endereço', error);
        }
      }
    },
  },
};
</script>

<style scoped>
input:disabled,
select:disabled {
  background-color: #f3f4f6;
}
</style>
