<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { getInitials } from '@/composables/useInitials';
import { BreadcrumbItem, SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronDown, Menu } from 'lucide-vue-next';
import { computed } from 'vue';
import Icon from '@/components/Icon.vue';

interface Props {
    breadcrumbs?: BreadcrumbItem[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage<SharedData>();
const auth = computed(() => page.props.auth);

const activeItemStyles = computed(
    () => (url: string) => (route().current(url) ? 'font-semibold' : ''),
);

</script>

<template>
    <div>
        <div class="border-b border-sidebar-border/80 bg-primary">
            <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                <!-- Mobile Menu -->
                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button variant="ghost" size="icon" class="text-white mr-2 h-9 w-9">
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-[300px] p-6 bg-primary text-primary-foreground">
                            <SheetTitle class="sr-only">Navigation Menu</SheetTitle>
                            <SheetHeader class="flex justify-start text-left">
                                <AppLogoIcon/>
                            </SheetHeader>
                            <div class="flex h-full flex-1 flex-col justify-between space-y-4 py-6">
                                <nav class="-mx-3 space-y-1">
                                    <template v-for="item in page.props.sideBarMenus">
                                        <Link
                                            v-if="item.children?.length === 0"
                                            :key="item.title"
                                            :href="route(item.url)"
                                            class="flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium hover:bg-accent"
                                            :class="activeItemStyles(item.url)"
                                        >
                                            <icon v-if="item.icon" :name="item.icon" class="h-5 w-5" />
                                            {{ item.title }}
                                        </Link>
                                        <template v-if="item.children?.length !== 0">
                                            <Link
                                                v-for="subItems in item.children"
                                                :key="subItems.title"
                                                :href="route(subItems.url)"
                                                class="flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium hover:bg-accent"
                                                :class="activeItemStyles(subItems.url)"
                                            >
                                                <icon v-if="subItems.icon" :name="subItems.icon" class="h-5 w-5" />
                                                {{ subItems.title }}
                                            </Link>
                                        </template>
                                    </template>

                                </nav>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <Link :href="route('dashboard')" class="flex items-center gap-x-2">
                    <AppLogo />
                </Link>

                <div class="ml-auto flex items-center space-x-2">
                    <DropdownMenu>
                        <DropdownMenuTrigger :as-child="true">
                            <Button
                                variant="ghost"
                                size="icon"
                                class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
                            >
                                <Avatar class="size-8 overflow-hidden rounded-full">
                                    <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar" :alt="auth.user.name" />
                                    <AvatarFallback class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white">
                                        {{ getInitials(auth.user?.name) }}
                                    </AvatarFallback>
                                </Avatar>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-56">
                            <UserMenuContent :user="auth.user" />
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>
        </div>

        <div class="bg-white flex w-full border-b border-sidebar-border/70">
            <div class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl">
                <NavigationMenu class="flex h-full items-stretch">
                    <NavigationMenuList class="flex h-full items-stretch space-x-2">
                        <template v-for="(item, index) in page.props.sideBarMenus" :key="index">
                            <NavigationMenuItem
                                v-if="!item.children || item.children.length === 0"
                                class="relative flex h-full items-center"
                            >
                                <Link :href="route(item.url)">
                                    <NavigationMenuLink
                                        :class="[navigationMenuTriggerStyle(), activeItemStyles(item.url), 'h-9 cursor-pointer px-3 text-black hover:font-semibold']"
                                    >
                                        <icon v-if="item.icon" :name="item.icon" class="mr-2 h-4 w-4" />
                                        {{ item.title }}
                                    </NavigationMenuLink>
                                </Link>
                                <div
                                    v-if="route().current(item.url)"
                                    class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px "
                                />
                            </NavigationMenuItem>

                            <NavigationMenuItem
                                v-else
                                class="relative flex h-full items-center"
                            >
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                        <NavigationMenuLink
                                            :class="[navigationMenuTriggerStyle(), 'h-9 cursor-pointer px-3 text-black hover:font-semibold']"
                                        >
                                            <icon v-if="item.icon" :name="item.icon" class="mr-2 h-4 w-4" />
                                            {{ item.title }}
                                            <ChevronDown class="ml-2 h-4 w-4" />
                                            <div
                                                v-if="route().current(`${item.url}.*`)"
                                                class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-white"
                                            />
                                        </NavigationMenuLink>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="start" class="w-48 mt-2 z-50">
                                        <Link
                                            v-for="subItem in item.children"
                                            :key="subItem.title"
                                            :href="route(subItem.url)"
                                            class="flex items-center gap-x-2 px-3 py-2 text-sm hover:bg-accent"
                                        >
                                            <icon v-if="subItem.icon" :name="subItem.icon" class="h-4 w-4" />
                                            {{ subItem.title }}
                                        </Link>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </NavigationMenuItem>
                        </template>
                        <NavigationMenuItem class="relative flex h-full items-center">
                            <Link :href="route('profile.edit')">
                                <NavigationMenuLink
                                    :class="[navigationMenuTriggerStyle(), activeItemStyles('profile.edit'), 'h-9 cursor-pointer px-3 text-black hover:font-semibold']"
                                >
                                    <icon name="Settings" class="mr-2 h-4 w-4" />
                                    Profile
                                </NavigationMenuLink>
                            </Link>
                            <div
                                v-if="route().current('profile.edit')"
                                class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px "
                            />
                        </NavigationMenuItem>
                    </NavigationMenuList>
                </NavigationMenu>
            </div>
        </div>
    </div>
</template>
