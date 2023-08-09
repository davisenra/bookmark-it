export const useTitleGenerator = (url: string): string => {
    const path = new URL(url).pathname;
    const words = path.split(/[/_-]/).filter((word) => word.length > 3);

    return words.map((word) => word.charAt(0).toUpperCase() + word.slice(1)).join(" ");
};
