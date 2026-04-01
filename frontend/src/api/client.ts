export async function fetchCatalog(board: string) {
  const response = await fetch(`/${board}/catalog.json`);
  if (!response.ok) {
    throw new Error(`Failed to fetch catalog for /${board}/`);
  }
  return response.json();
}

export async function fetchThread(board: string, id: number) {
  const response = await fetch(`/${board}/thread/${id}.json`);
  if (!response.ok) {
    throw new Error(`Failed to fetch thread /${board}/${id}`);
  }
  return response.json();
}
