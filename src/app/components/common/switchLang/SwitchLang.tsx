"use client";
import GeneralButton from '@/app/components/common/generalButton/GeneralButton';
import { useInitialLoader } from '@/app/store/useInitialLoader';
import useToggleMenu from '@/app/store/useToggleMenu';
import clsx from 'clsx';
import { useLocale } from 'next-intl';
import { useRouter, usePathname } from 'next/navigation';
import React, { useEffect, useRef } from 'react';

type Props = {
  customClass?: string
}
const SwitchLang: React.FC<Props> = ({customClass}) => {
  const lang = useLocale();
  const router = useRouter();
  const pathname = usePathname();
  const { show: showLoader, setProgress } = useInitialLoader();
  const { closeMenu } = useToggleMenu();
  const isChangingLang = useRef(false);
  
  // ✅ لما اللغة تتغير، نخفي اللودر
  useEffect(() => {
    if (isChangingLang.current) {
      // نخلي اللودر يوصل 100% ويختفي
      setTimeout(() => {
        setProgress(100);
        setTimeout(() => {
          isChangingLang.current = false;
        }, 800);
      }, 500);
    }
  }, [lang, setProgress]);
  
  const changeLang = () => {
    const newLang = lang === 'en' ? 'ar' : 'en';

    // ✅ نقفل المنيو الأول قبل تغيير اللغة
    closeMenu();

    // ✅ نشغل Initial Loader
    isChangingLang.current = true;
    showLoader();
    setProgress(0);

    // محاكاة تقدم التحميل
    let progress = 0;
    const interval = setInterval(() => {
      progress += 15;
      if (progress <= 85) {
        setProgress(progress);
      } else {
        clearInterval(interval);
      }
    }, 50);

    // نشيل أول segment (اللغة) من ال pathname
    const segments = pathname.split('/');
    segments[1] = newLang; // نستبدل اللغة الحالية بالجديدة
    const newPath = segments.join('/') || '/';

    // تغيير اللغة
    setTimeout(() => {
      router.push(newPath);
    }, 100);
  };
  return (
    <GeneralButton
      title={lang === "en" ? "عربي" : "en"}
      isWhite
      customClass={clsx("xl:block lg:block md:block hidden" , customClass)}
      isPillEffect
      customClick={changeLang}
    />
  );
};

export default SwitchLang;
