import { notFound } from 'next/navigation';

export default function CatchAllPage() {
  // ✅ أي route مش موجود هيروح للـ not-found page
  notFound();
}

