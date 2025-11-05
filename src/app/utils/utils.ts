export function formatNumber(number: number, decimals: number = 1): string {
    if (number < 1000) {
        return number.toString();
    }

    const units = [
        { value: 1_000_000_000, symbol: "B" },
        { value: 1_000_000, symbol: "M" },
        { value: 1_000, symbol: "K" },
    ];

    for (const unit of units) {
        if (number >= unit.value) {
            const formatted = (number / unit.value).toFixed(decimals);
            return parseFloat(formatted) + unit.symbol;
        }
    }

    return number.toString();
}
