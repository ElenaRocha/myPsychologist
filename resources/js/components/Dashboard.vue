<template>
  <div>
    <h1>Dashboard</h1>
    <ul>
      <li v-for="appointment in appointments" :key="appointment.id">
        {{ appointment.date }} - {{ appointment.time }}
      </li>
    </ul>
    <button @click="showAppointmentForm = true">Agendar Cita</button>
    <form v-if="showAppointmentForm" @submit.prevent="scheduleAppointment">
      <input v-model="date" type="date" required>
      <input v-model="time" type="time" required>
      <button type="submit">Agendar</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      appointments: [],
      showAppointmentForm: false,
      date: '',
      time: '',
    };
  },
  async created() {
    const response = await axios.get('/api/appointments');
    this.appointments = response.data;
  },
  methods: {
    async scheduleAppointment() {
      try {
        const response = await axios.post('/api/appointments', {
          date: this.date,
          time: this.time,
        });
        this.appointments.push(response.data);
        this.showAppointmentForm = false;
      } catch (error) {
        alert('Error al agendar cita');
      }
    },
  },
};
</script>