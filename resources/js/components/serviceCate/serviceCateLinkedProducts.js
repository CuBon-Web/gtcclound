export function emptyLinkedProductCategories() {
  return { selections: [] };
}

export function normalizeLinkedProductCategories(raw) {
  if (!raw || typeof raw !== "object") {
    return emptyLinkedProductCategories();
  }
  let s = raw.selections;
  if (!Array.isArray(s)) {
    return emptyLinkedProductCategories();
  }
  return {
    selections: s
      .map((row) => ({
        category_id: Number(row.category_id) || 0,
        type_cate_id: Number(row.type_cate_id) || 0,
        type_two_ids: Array.isArray(row.type_two_ids)
          ? row.type_two_ids.map((x) => Number(x)).filter((n) => n > 0)
          : [],
      }))
      .filter((row) => row.type_cate_id > 0),
  };
}

export function serializeLinkedProductCategories(raw) {
  const n = normalizeLinkedProductCategories(raw);
  return n;
}
