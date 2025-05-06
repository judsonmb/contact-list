<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <form @submit.prevent="submitForm" class="bg-white p-4 rounded-lg shadow-lg w-full max-w-sm space-y-3">
      <div v-if="feedback.message" :class="feedbackClass" class="w-full text-white px-4 py-2 rounded-md text-center mb-4">
        {{ feedback.message }}
      </div>

      <h2 class="text-xl font-semibold text-center text-gray-800">Cadastro de Contato</h2>

      <div>
        <label class="block text-gray-700 font-medium mb-1" for="name">Nome</label>
        <input
          type="text"
          v-model="name"
          id="name"
          required
          class="w-full border border-gray-300 rounded-md px-4 py-2"
        />
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1" for="email">Email</label>
        <input
          type="email"
          v-model="email"
          id="email"
          required
          class="w-full border border-gray-300 rounded-md px-4 py-2"
        />
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1" for="phone">Telefone</label>
        <input
          type="tel"
          v-model="phone"
          id="phone"
          required
          class="w-full border border-gray-300 rounded-md px-4 py-2"
        />
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1" for="postal_code">CEP</label>
        <input
          type="text"
          id="postal_code"
          v-model="postal_code"
          @blur="fetchAddress"
          maxlength="8"
          required
          class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1" for="state">Estado</label>
        <select
          v-model="state"
          id="state"
          required
          class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
        >
          <option value="" disabled>Selecione um estado</option>
          <option v-for="estado in states" :key="estado.uf" :value="estado.uf">
            {{ estado.name }}
          </option>
        </select>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1" for="city">Cidade</label>
        <input
          type="text"
          v-model="city"
          id="city"
          required
          :disabled="!cityEditable"
          class="w-full border border-gray-300 rounded-md px-4 py-2 bg-white"
        />
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1" for="address">Endereço</label>
        <input
          type="text"
          v-model="address"
          id="address"
          required
          :disabled="!addressEditable"
          class="w-full border border-gray-300 rounded-md px-4 py-2 bg-white"
        />
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1" for="number">Número</label>
        <input
          type="text"
          v-model="number"
          id="number"
          required
          class="w-full border border-gray-300 rounded-md px-4 py-2"
        />
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1" for="district">Bairro</label>
        <input
          type="text"
          v-model="district"
          id="district"
          required
          :disabled="!districtEditable"
          class="w-full border border-gray-300 rounded-md px-4 py-2 bg-white"
        />
      </div>

      <button
        type="submit"
        :disabled="loading"
        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition cursor-pointer disabled:bg-blue-400"
      >
        <span v-if="loading">Carregando...</span>
        <span v-else>Salvar Contato</span>
      </button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      postal_code: '',
      state: '',
      city: '',
      district: '',
      address: '',
      number: '',
      name: '',
      email: '',
      phone: '',
      cityEditable: false,
      districtEditable: false,
      addressEditable: false,
      loading: false,
      feedback: {
        type: '',
        message: '',
      },
      states: [],
    };
  },
  computed: {
    feedbackClass() {
      switch (this.feedback.type) {
        case 'success': return 'bg-green-500';
        case 'error': return 'bg-red-500';
        case 'warning': return 'bg-yellow-500 text-gray-900';
        default: return '';
      }
    },
  },
  methods: {
    async fetchStates() {
      try {
        const { data } = await axios.get('/api/states');
        this.states = data.data || [];
      } catch (error) {
        this.feedback = {
          type: 'error',
          message: 'Erro ao carregar os estados.',
        };
      }
    },
    async fetchAddress() {
      if (this.postal_code.length !== 8) return;

      try {
        const { data } = await axios.get(`https://cep.awesomeapi.com.br/json/${this.postal_code}`);

        const statesList = JSON.parse(JSON.stringify(this.states));

        const state = statesList.find(s => s.abbreviation === data.state);

        if (state) {
          this.states = state.abbreviation;
        }

        this.city = data.city || '';
        this.cityEditable = !data.city;

        this.district = data.district || '';
        this.districtEditable = !data.district;

        this.address = data.address_name || '';
        this.addressEditable = !data.address_name;
      } catch (e) {
        alert('CEP inválido ou não encontrado.');
        this.cityEditable = true;
        this.districtEditable = true;
        this.addressEditable = true;
      }
    },
    async submitForm() {
      this.feedback = { type: '', message: '' };
      this.loading = true;

      try {
        await axios.post('/api/contacts', {
          postal_code: this.postal_code,
          state: this.state,
          city: this.city,
          district: this.district,
          address: this.address,
          number: this.number,
          name: this.name,
          email: this.email,
          phone: this.phone,
        });

        this.feedback = {
          type: 'success',
          message: 'Contato salvo com sucesso!',
        };

        this.$emit('contactCreated');
      } catch (error) {
        if (error.response) {
          if (error.response.status === 422) {
            const messages = Object.values(error.response.data.errors || {}).flat().join(' ');
            this.feedback = {
              type: 'warning',
              message: messages || 'Dados inválidos. Verifique os campos.',
            };
          } else if (error.response.status === 500) {
            this.feedback = {
              type: 'error',
              message: 'Erro interno do servidor. Tente novamente mais tarde.',
            };
          } else {
            this.feedback = {
              type: 'error',
              message: 'Erro inesperado. Verifique sua conexão ou tente novamente.',
            };
          }
        } else {
          this.feedback = {
            type: 'error',
            message: 'Erro de conexão com o servidor.',
          };
        }
      } finally {
        this.loading = false;
      }
    },
  },
  mounted() {
    this.fetchStates();
  },
};
</script>
