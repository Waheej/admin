"use client";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import UnitDetailsPopup from "@/app/components/common/unitDetailsPopup/UnitDetailsPopup";
import ParallaxImage from "@/app/components/module/parallaxImage/ParallaxImage";
import { directionIcon, markerIcon } from "@/app/data/data";
import useGeneralPopUp from "@/app/store/useGeneralPopUp";
import React from "react";

const ProjectMap = ({ projects }: { projects: any }) => {
    const [selectedUnit, setSelectedUnit] = React.useState<any>(null);
    const containerRef = React.useRef<HTMLDivElement>(null);

    // ✅ شلنا الأنيميشن لأننا مش محتاجين filter layer دلوقتي
    // لو عايز تضيف filter layer تاني، ارجع الكود ده

    const { setChildren } = useGeneralPopUp();

    // فتح Google Maps للوحدة المحددة أو أول وحدة
    const openDirections = () => {
        const unit = selectedUnit || projects?.[0];
        if (unit?.lat && unit?.long) {
            const url = `https://www.google.com/maps/dir/?api=1&destination=${unit.lat},${unit.long}`;
            window.open(url, '_blank');
        }
    };
    return (
        <section ref={containerRef} className="project-map h-screen">
            <div className="project-map-image relative h-full w-full overflow-hidden rounded-3xl">
                <ParallaxImage src={"/images/map.png"} alt="Map" />

                <div className="project-map-image-layer absolute inset-0 top-0 left-0 w-full h-full p-8 flex items-start">
                    <div className="project-map-image-layer-btns flex items-center gap-4 justify-end w-full">
                        {/* Direction Button - يفتح Google Maps */}
                        <GeneralButton 
                            isPillEffect 
                            isWhite 
                            icon={directionIcon} 
                            customClass="shadow-lg relative z-[2]"
                            customClick={openDirections}
                        />

                    </div>

                    {/* ✅ الماركرز من الـ projects data */}
                    <div className="project-map-image-pin-markers w-full h-full absolute top-0 left-0 pointer-events-none">
                        {projects?.map((project: any, index: number) => {
                            // تحقق من وجود lat و long
                            if (!project?.lat || !project?.long) return null;

                            // حساب الموقع على الخريطة (normalize coordinates)
                            // هنا ممكن تحتاج تعدل حسب نطاق الخريطة الفعلي
                            const normalizeCoordinate = (lat: string, lng: string) => {
                                // مثال بسيط - ممكن تحتاج تعديل حسب الخريطة
                                const latNum = parseFloat(lat);
                                const lngNum = parseFloat(lng);
                                
                                // تحويل للنسبة المئوية (هذا مثال - عدّله حسب خريطتك)
                                // مثلاً: Riyadh area: lat 24-25, lng 46-47
                                const topPercent = ((25 - latNum) / 1) * 100; // عكسي
                                const leftPercent = ((lngNum - 46) / 1) * 100;
                                
                                return {
                                    top: `${Math.max(10, Math.min(90, topPercent))}%`,
                                    left: `${Math.max(10, Math.min(90, leftPercent))}%`,
                                };
                            };

                            const position = normalizeCoordinate(project.lat, project.long);

                            return (
                                <div
                                    onClick={() => {
                                        setSelectedUnit(project);
                                        setChildren(<UnitDetailsPopup project={project}/>, "unit-details");
                                    }}
                                    key={project.id}
                                    className="marker-pulse w-11 h-11 flex items-center justify-center absolute cursor-pointer shadow-xl pointer-events-auto"
                                    style={{
                                        top: position.top,
                                        left: position.left,
                                        transform: "translate(-50%, -50%)",
                                    }}>
                                    <div className="absolute inset-0 bg-white rounded-full animate-ping" style={{ animationDuration: ".6s" }}></div>
                                    <div className="marker bg-primary w-10 h-10 rounded-full text-white flex items-center justify-center relative z-10 hover:scale-110 transition-transform">
                                        <div className="marker-icon">{markerIcon}</div>
                                    </div>
                                    
                                    {/* Tooltip */}
                                    <div className="absolute -top-12 left-1/2 -translate-x-1/2 bg-white px-3 py-1 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                        <p className="text-xs font-bold">{project.name}</p>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </div>
            </div>
        </section>
    );
};

export default ProjectMap;
