export function emptyFeature() {
  return { label: "", type: "text", value: "" };
}

export function emptyPlan() {
  return {
    title: "",
    price: "",
    unit: "tháng",
    features: [emptyFeature()],
  };
}

export function serializePricingPlans(plans) {
  if (!Array.isArray(plans)) return [];
  return plans
    .map((plan) => ({
      title: plan.title,
      price: plan.price,
      unit: plan.unit,
      features: (plan.features || [])
        .filter((f) => f.label && String(f.label).trim())
        .map((f) => ({
          label: f.label,
          type: f.type === "boolean" ? "boolean" : "text",
          value: f.type === "boolean" ? !!f.value : f.value,
        })),
    }))
    .filter((plan) => plan.title && String(plan.title).trim());
}

export function normalizePricingPlans(raw) {
  let plans = raw;
  if (plans == null) return [];
  if (typeof plans === "string") {
    try {
      plans = JSON.parse(plans);
    } catch (e) {
      return [];
    }
  }
  if (!Array.isArray(plans)) return [];
  return plans.map((plan) => {
    const p = { ...plan };
    if (!Array.isArray(p.features)) {
      p.features = [];
    }
    p.features = p.features.map((f) => {
      const type = f.type === "boolean" ? "boolean" : "text";
      let value = f.value;
      if (type === "boolean") {
        value = value === true || value === 1 || value === "1";
      }
      return { label: f.label || "", type, value };
    });
    if (p.features.length === 0) {
      p.features.push(emptyFeature());
    }
    return {
      title: p.title || "",
      price: p.price || "",
      unit: p.unit || "tháng",
      features: p.features,
    };
  });
}
