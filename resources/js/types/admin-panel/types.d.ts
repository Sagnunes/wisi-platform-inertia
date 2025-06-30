import { User } from '@/types';

export interface Paginator<T> {
    current_page: number;
    data: T[];
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}

interface StatusDTO {
    name: string;
    slug: string;
    id: number;
    description: string | null;
    created_at: string;
}

interface PermissionDTO {
    name: string;
    slug: string;
    id: number;
    description: string | null;
    created_at: string;
}

interface RoleDTO {
    name: string;
    slug: string;
    id: number;
    description: string | null;
    created_at: string;
}

interface RolePermission extends Role {
    permissions: Permission[];
}

interface UserWithStatusAndRoles extends User {
    status: StatusDTO;
    roles: RoleDTO[];
}

export type { PermissionDTO, RoleDTO, RolePermission, StatusDTO, UserWithStatusAndRoles };
