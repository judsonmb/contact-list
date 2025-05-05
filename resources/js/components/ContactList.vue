<template>
  <div class="min-h-screen bg-gray-100 p-4 flex">
    <div class="w-2/3 pr-4">
      <h1 class="text-3xl font-semibold text-center mb-6">Lista de Contatos</h1>
      <table class="min-w-full bg-white rounded-md shadow-md">
        <thead>
          <tr>
            <th class="px-4 py-2 text-left">Nome</th>
            <th class="px-4 py-2 text-left">E-mail</th>
            <th class="px-4 py-2 text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="contact in contacts" :key="contact.id">
            <td class="px-4 py-2">{{ contact.name }}</td>
            <td class="px-4 py-2">{{ contact.email }}</td>
            <td class="px-4 py-2 text-center">
              <button @click="showContact(contact.id)" class="text-blue-600 hover:underline">Mostrar Info</button>
              <button @click="editContact(contact.id)" class="text-yellow-600 hover:underline mx-2">Editar</button>
              <button @click="deleteContact(contact.id)" class="text-red-600 hover:underline">Deletar</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="w-1/3 pl-4">
      <ContactForm @contactCreated="fetchContacts" />
    </div>

    <show-contact-info v-if="showInfo" :contact="selectedContact" @close="closeModal" />
    <edit-contact v-if="showEdit" :contact="selectedContact" @close="closeModal" :loading="loading" />
  </div>
</template>

<script>
import axios from 'axios';
import ShowContactInfo from './ShowContactInfo.vue';
import EditContact from './EditContact.vue';
import ContactForm from './ContactForm.vue';

export default {
  components: {
    ShowContactInfo,
    EditContact,
    ContactForm,
  },
  data() {
    return {
      contacts: [],
      showInfo: false,
      showEdit: false,
      selectedContact: null,
      loading: false,
    };
  },
  mounted() {
    this.fetchContacts();
  },
  methods: {
    async fetchContacts() {
      try {
        const res = await axios.get('/api/contacts');
        this.contacts = res.data.data;
      } catch (error) {
        console.error('Erro ao carregar contatos', error);
      }
    },
    showContact(id) {
      this.selectedContact = this.contacts.find(contact => contact.id === id);
      this.showInfo = true;
    },
    async editContact(id) {
      this.loading = true;
      this.selectedContact = this.contacts.find(contact => contact.id === id);
      await this.loadAddressData();
      this.showEdit = true;
      this.loading = false;
    },
    async loadAddressData() {
      try {
        if (this.selectedContact.postal_code) {
          const response = await axios.get(`https://viacep.com.br/ws/${this.selectedContact.postal_code}/json/`);
          this.selectedContact.state = response.data.uf;
          this.selectedContact.city = response.data.localidade;
          this.selectedContact.district = response.data.bairro;
          this.selectedContact.address = response.data.logradouro;
        }
      } catch (error) {
        console.error('Erro ao carregar dados do CEP', error);
      }
    },
    async deleteContact(id) {
      try {
        await axios.delete(`/api/contacts/${id}`);
        this.fetchContacts();
      } catch (error) {
        console.error('Erro ao deletar contato', error);
      }
    },
    closeModal() {
      this.showInfo = false;
      this.showEdit = false;
    },
  },
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  padding: 12px;
  text-align: left;
}
th {
  background-color: #f4f4f4;
}
button {
  cursor: pointer;
}
</style>
