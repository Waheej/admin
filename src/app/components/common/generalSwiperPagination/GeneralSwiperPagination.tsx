import clsx from 'clsx'
import React from 'react'

type TGeneralSwiperPagination = {
    customClass?: string
}
const GeneralSwiperPagination: React.FC<TGeneralSwiperPagination> = ({ customClass}) => {
  return (
      <div className={clsx('general-swiper-pagination flex justify-center gap-1 mt-8', customClass)}>
          
    </div>
  )
}

export default GeneralSwiperPagination