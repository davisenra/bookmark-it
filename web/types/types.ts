type ApiResponseMetada = {
  links: {
    first: string;
    last: string;
    prev: string | null;
    next: string | null;
  };
  meta: {
    current_page: number;
    from: number;
    last_page: number;
    links: {
      url: string | null;
      label: string;
      active: boolean;
    }[];
    path: string;
    per_page: number;
    to: number;
    total: number;
  };
};

export type Tag = {
  id: number;
  name: string;
};

export type TagResponse = ApiResponseMetada & {
  data: Tag[];
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

export type BookmarkResponse = ApiResponseMetada & {
  data: Bookmark[];
};
