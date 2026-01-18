<template>
  <q-page class="q-pa-md">
    <div class="row q-col-gutter-md">
      <div class="col-12 col-sm-6 col-md-4">
        <q-card>
          <q-card-section>
            <div class="row items-center q-mb-sm">
              <q-icon name="group" size="32px" color="primary" class="q-mr-sm" />
              <div class="text-h6">Kunden</div>
            </div>

            <div class="text-h4 text-weight-bold q-mb-xs">
              {{ stats.total }}
            </div>

            <div class="text-caption text-grey-7" v-if="stats.lastAdded">
              Letzter Kunde hinzugefügt: <span class="text-black"> {{ stats.lastAdded }} </span>
            </div>
            <div v-else class="text-caption text-grey-7">
              <span>Es wurden noch keine Kunden angelegt</span>
            </div>

          </q-card-section>

          <q-separator />

          <q-card-actions>
            <q-btn
              flat
              color="primary"
              label="Alle anzeigen"
              @click="goToCustomers"
            />
          </q-card-actions>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from 'src/services/api'

const router = useRouter()

const stats = ref({
  total: 0,
  lastAdded: 'Loading...'
})

async function fetchStats() {
  try {
    const response = await api.get('/customers/stats')
    stats.value = response.data
  } catch (error) {
    console.error('Failed to fetch stats:', error)
  }
}

function goToCustomers() {
  router.push('/customers')
}

onMounted(() => {
  fetchStats()
})
</script>
