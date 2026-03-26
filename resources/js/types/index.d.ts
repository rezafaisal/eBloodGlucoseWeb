import type { PageProps } from '@inertiajs/core';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string
    url: string
    icon: string
    isActive?: boolean
    children?: {
        title: string
        url: string
        icon: string
    }[]
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sideBarMenus: any;
}

export interface User {
    id: number;
    name: string;
    email: string;
    age?: number | null;
    gender?: "male" | "female" | null;
    blood_type?: "A" | "B" | "AB" | "O" | null;
    height?: number | null;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
