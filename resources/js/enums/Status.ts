enum Statuses {
    PENDING = 1,
    ACTIVE = 2,
    BLOCKED = 3
}

// English display names
const statusDisplayName: Record<Statuses, string> = {
    [Statuses.PENDING]: 'Pending',
    [Statuses.ACTIVE]: 'Active',
    [Statuses.BLOCKED]: 'Blocked',
};

// Portuguese translations
const statusTranslatedName: Record<Statuses, string> = {
    [Statuses.PENDING]: 'Pendente',
    [Statuses.ACTIVE]: 'Ativo',
    [Statuses.BLOCKED]: 'Bloqueado',
};

// Map numeric ID to translated name
function getTranslatedName(statusId: Statuses): string {
    return statusTranslatedName[statusId];
}

// Map translated name to numeric ID
function fromTranslatedName(name: string): Statuses | null {
    const entry = Object.entries(statusTranslatedName).find(
        ([, translated]) => translated === name
    );
    return entry ? Number(entry[0]) as Statuses : null;
}

// Map numeric ID to English name
function getDisplayName(statusId: Statuses): string {
    return statusDisplayName[statusId];
}

// Map English name to numeric ID
function fromDisplayName(name: string): Statuses | null {
    const entry = Object.entries(statusDisplayName).find(
        ([, display]) => display === name
    );
    return entry ? Number(entry[0]) as Statuses : null;
}

export {
    Statuses,
    getTranslatedName,
    fromTranslatedName,
    getDisplayName,
    fromDisplayName
};
