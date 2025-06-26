export interface Role {
    id: number;
    name: string;
    slug: string;
    description: ?string;
    created_by_id: string;
    created_at: Date;
    updated_at: ?Date;
}
