export async function useApiFetch(
  path: string,
  options?: RequestInit,
): Promise<Response> {
  const token = useCookie("XSRF-TOKEN");

  const headers = {
    Accept: "application/json",
    "Content-Type": "application/json",
    Referer: useRuntimeConfig().public.appDomain,
    "X-XSRF-TOKEN": token.value as string,
  };

  return fetch(`${useRuntimeConfig().public.apiBase + path}`, {
    credentials: "include",
    ...options,
    headers: {
      ...headers,
      ...options?.headers,
    },
  });
}
