export const useTitleGenerator = async (url: string) => {
    const res = await useApiFetch(
        `/v1/title-generator?` +
            new URLSearchParams({
                url: url,
            }),
    );

    if (!res.ok) {
        return null;
    }

    const { data } = await res.json();

    if (data.title !== null) {
        return data.title as string;
    }

    return null;
};
