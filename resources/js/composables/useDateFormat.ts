export function useDateFormat() {
    function formatDateTime(dateString: string) {
        const date = new Date(dateString)

        const day = date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric',
        })

        const hour = date.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
        })

        return { day, hour }
    }

    return { formatDateTime }
}
