export type Tag = {
  id: number;
  name: string;
};

export type Bookmark = {
  id: string;
  title: string;
  description: string | null;
  url: string;
  tags: Tag[] | [];
  visited: boolean;
  visited_at: string | null;
  created_at: string;
  updated_at: string;
};
