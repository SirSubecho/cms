<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated class="bg-dark text-white">
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          @click="toggleLeftDrawer"
        >
          <Bars3Icon style="width: 24px; height: 24px;" />
        </q-btn>

        <q-toolbar-title>
          <span class="cursor-pointer" @click="routeHome">CMS</span> | {{ pageTitle }}
        </q-toolbar-title>

        <UserDropdown />
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      :width="250"
    >
      <q-list>
        <q-item-label header class="text-grey-8">
          Navigation
        </q-item-label>

        <q-item
          clickable
          v-ripple
          :active="$route.path === '/'"
          active-class="bg-primary text-white"
          @click="router.push('/')"
        >
          <q-item-section avatar>
            <ChartBarIcon style="width: 24px; height: 24px;" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Dashboard</q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          clickable
          v-ripple
          :active="$route.path === '/customers'"
          active-class="bg-primary text-white"
          @click="router.push('/customers')"
        >
          <q-item-section avatar>
            <UsersIcon style="width: 24px; height: 24px;" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Kunden</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { Bars3Icon, ChartBarIcon, UsersIcon } from '@heroicons/vue/24/outline'
import UserDropdown from 'components/UserDropdown.vue'

const route = useRoute()
const router = useRouter()

const leftDrawerOpen = ref(false)

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value
}

function routeHome() {
  router.push('/')
}

const pageTitle = computed(() => {
  return route.meta.title || 'CMS'
})
</script>
