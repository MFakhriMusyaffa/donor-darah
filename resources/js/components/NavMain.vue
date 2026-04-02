<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import type { NavItem } from '@/types';

defineProps<{
    items: NavItem[];
}>();

const { isCurrentUrl } = useCurrentUrl();
const { state } = useSidebar();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel v-if="state === 'expanded'" class="text-xs font-semibold text-sidebar-foreground/60 uppercase tracking-wide">Menu</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton
                    as-child
                    :is-active="isCurrentUrl(item.href)"
                    :tooltip="item.title"
                    class="menu-button-improved"
                >
                    <Link 
                        :href="item.href"
                        class="menu-link-improved"
                        :class="isCurrentUrl(item.href) && state === 'expanded' ? 'active-menu' : ''"
                    >
                        <component :is="item.icon" class="icon-nav" />
                        <span v-if="state === 'expanded'" class="font-medium text-sm">{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>

<style scoped>
/* Prevent icons from being cut off in collapsed state */
:deep(.icon-nav) {
    flex-shrink: 0;
    min-width: 1rem;
    width: 1rem;
    height: 1rem;
}

/* Menu button improvements */
:deep(.menu-button-improved) {
    transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 0.5rem;
}

/* Menu link improvements */
:deep(.menu-link-improved) {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    width: 100%;
}

:deep([data-collapsible="icon"] .menu-link-improved) {
    justify-content: center;
    gap: 0;
}

/* Active state indicator */
:deep(.active-menu) {
    background: linear-gradient(135deg, rgb(239 68 68) 0%, rgb(220 38 38) 100%);
    color: white;
    font-weight: 600;
    position: relative;
}

:deep(.active-menu .icon-nav) {
    filter: brightness(1.2);
}

/* Smooth transition for hover */
:deep(.menu-button-improved:hover) {
    transition: all 200ms ease-out;
}
</style>
