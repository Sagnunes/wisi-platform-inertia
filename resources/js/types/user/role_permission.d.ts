import { Role } from '@/types/user/role';
import { Permission } from '@/types/user/permissions';

export interface RolePermission extends Role{
    permissions: Permission[];
}
